<?php

namespace AppBundle\Controller;

use PHPExcel_Shared_Date;
use PHPExcel_Style_NumberFormat;
use AppBundle\Entity\Cuenta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cuentum controller.
 *
 * @Route("/cuenta")
 */
class CuentaController extends Controller
{
    /**
     * Lists all cuenta entities.
     *
     * @Route("/", name="cuenta_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        list($qb, $filterForm) = $this->filter($request);

        //$pisos = $qb->getQuery()->getResult();

        $paginator  = $this->get('knp_paginator');
        $cuentas = $paginator->paginate(
            $qb, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );
        //$pisos = $em->getRepository('AppBundle:Piso')->findAll();

        return $this->render('cuenta/index.html.twig', array(
            'filterForm' => $filterForm->createView(),
            'cuentas' => $cuentas,

        ));
    }

    /**
     * Creates a new cuenta entity.
     *
     * @Route("/new", name="cuenta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cuentum = new Cuenta();
        $form = $this->createForm('AppBundle\Form\CuentaType', $cuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cuentum);
            $em->flush($cuentum);

            $this->addFlash(
               'success',
               'Los datos fueron guardados correctamente.'
             );

            return $this->redirectToRoute('cuenta_show', array('id' => $cuentum->getId()));
        }

        return $this->render('cuenta/new.html.twig', array(
            'cuentum' => $cuentum,
            'form' => $form->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing cuentum entity.
     *
     * @Route("/{id}/edit", name="cuenta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cuenta $cuentum)
    {
        $deleteForm = $this->createDeleteForm($cuentum);
        $editForm = $this->createForm('AppBundle\Form\CuentaType', $cuentum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
               'success',
               'Los datos fueron guardados correctamente.'
             );

            return $this->redirectToRoute('cuenta_edit', array('id' => $cuentum->getId()));
        }

        return $this->render('cuenta/edit.html.twig', array(
            'cuentum' => $cuentum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cuentum entity.
     *
     * @Route("/{id}", name="cuenta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cuenta $cuentum)
    {
        $form = $this->createDeleteForm($cuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cuentum);
            $em->flush($cuentum);
        }

        return $this->redirectToRoute('cuenta_index');
    }

    /**
     * Creates a form to delete a cuentum entity.
     *
     * @param Cuenta $cuentum The cuentum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cuenta $cuentum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cuenta_delete', array('id' => $cuentum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    protected function filter(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $filterForm = $this->createForm('AppBundle\Form\CuentaFilterType');
      $qb = $em->getRepository('AppBundle:Cuenta')
        ->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC');

      //die(var_dump($_POST, $filterForm->getName()));
      $sesion = $request->getSession();

      if ($request->getMethod() == 'POST') {
        if($request->get('filtro') == 'buscar'){
          $filterForm->handleRequest($request);
          if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $request->request->get($filterForm->getName());
            $sesion->set('cuenta-filter', $data);
            $this->get('lexik_form_filter.query_builder_updater')
              ->addFilterConditions($filterForm, $qb);
          }
        } else {
          $sesion->remove('cuenta-filter');
        }
      } else {
        $data = $sesion->get('cuenta-filter', array());
        $filterForm->submit($data);
        $this->get('lexik_form_filter.query_builder_updater')
          ->addFilterConditions($filterForm, $qb);
      }

      return array($qb, $filterForm);
    }

    /**
     * Lists all cuenta entities.
     *
     * @Route("/excel", name="excel_index")
     * @Method({"GET","POST"})
     */
    public function excelAction(Request $request){
      list($qb, $filterForm) = $this->filter($request);

      $cuentas = $qb->getQuery()->getResult();
        // ask the service for a excel object
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
       $data = $filterForm->getData();
       $phpExcelObject->getProperties()->setCreator( 'random' )
           ->setLastModifiedBy('The Best')
           ->setTitle("Office 2005 XLSX Test Document")
           ->setSubject("Office 2005 XLSX Test Document")
           ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
           ->setKeywords("office 2005 openxml php")
           ->setCategory("Test result file");
       $dateTimeNow = time();

       $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A1', 'Fecha:')
           //Shared Date se usa para especificar la fecha y hora en que se imprime el Excel
           ->setCellValue('B1', PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ))
           ->setCellValue('A2', 'Filtrado por:')
           ->setCellValue('A3', 'Apellido:')
           ->setCellValue('B3', $data['apellido'])
           ->setCellValue('A4', 'Nombre:')
           ->setCellValue('B4', $data['nombre'])
           ->setCellValue('A5', 'D.N.I.:')
           ->setCellValue('B5', $data['dni'])
           ->setCellValue('A6', 'Mail:')
           ->setCellValue('B6', $data['mail'])
           ->setCellValue('A7', 'Jurisdiccion:')
           ->setCellValue('B7', $data['jurisdiccion'])

           ->setCellValue('A9', 'Id')
           ->setCellValue('B9', 'Apellido')
           ->setCellValue('C9', 'Nombre')
           ->setCellValue('D9', 'D.N.I.')
           ->setCellValue('E9', 'Usuario')
           ->setCellValue('F9', 'Mail')
           ->setCellValue('G9', 'Tipo')
           ->setCellValue('H9', 'Jurisdiccion')
           ->setCellValue('I9', 'Ticket');
       $phpExcelObject->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
       $phpExcelObject->getActiveSheet()->setTitle('Simple');

       $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

       $i=10;
       foreach ($cuentas as $cuenta) {
         $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $cuenta->getId())
           ->setCellValue('B'.$i, $cuenta->getApellido())
           ->setCellValue('C'.$i, $cuenta->getNombre())
           ->setCellValue('D'.$i, $cuenta->getDni())
           ->setCellValue('E'.$i, $cuenta->getMail())
           ->setCellValue('F'.$i, $cuenta->getTieneMail())
           ->setCellValue('G'.$i, $cuenta->getTipoCorreo())
           ->setCellValue('H'.$i, $cuenta->getJurisdiccion())
           ->setCellValue('I'.$i, $cuenta->getTicket());
           $i=$i+1;
       }

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'PhpExcelFileSample.xlsx'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    /**
     * Finds and displays a cuenta entity.
     *
     * @Route("/{id}", name="cuenta_show")
     * @Method("GET")
     */
    public function showAction(Cuenta $cuentum)
    {
        $deleteForm = $this->createDeleteForm($cuentum);

        return $this->render('cuenta/show.html.twig', array(
            'cuentum' => $cuentum,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
