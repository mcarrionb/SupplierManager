<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SupplierRepository;
use App\Entity\Supplier;
use App\Form\SupplierType;


/**
 * @Route("/suppliers")
 */
class SupplierController extends AbstractController
{
    /**
     * Get all suppliers
     * 
     * @Route("/", name="supplier_index", methods={"GET"})
     */
    public function index(SupplierRepository $supplierRepository): Response
    {
        return $this->render('supplier/index.html.twig', [
            'suppliers' => $supplierRepository->findAll(),
        ]);
    }

    /**
     * Create a new supplier
     * 
     * @Route("/new", name="supplier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($supplier);
            $em->flush();

            $this->addFlash('success', 'Proveedor creado correctamente.');
            return $this->redirectToRoute('supplier_index');
        }

        return $this->render('supplier/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Crear proveedor',
        ]);
    }

    /**
     * Edit an existing supplier
     * 
     * @Route("/{id}/edit", name="supplier_edit", methods={"GET", "POST"})
     */
    public function edit(Supplier $supplier, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Proveedor actualizado correctamente.');
            return $this->redirectToRoute('supplier_index');
        }

        return $this->render('supplier/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Editar proveedor',
        ]);
    }

    /**
     * Delete a supplier
     * 
     * @Route("/{id}/delete", name="supplier_delete", methods={"POST"})
     */
    public function delete(Supplier $supplier, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $supplier->getId(), $request->request->get('_token'))) {
            $em->remove($supplier);
            $em->flush();

            $this->addFlash('success', 'Proveedor eliminado correctamente.');
        }

        return $this->redirectToRoute('supplier_index');
    }
}
