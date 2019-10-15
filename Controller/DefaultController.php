<?php
namespace EasyadminDragndropSortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package EasyadminDragndropSortBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Resorts an item using it's doctrine sortable property
     *
     * @Route("/sort/{entityName}/{id}/{position}", name="easyadmin_dragndrop_sort_sort")
     * @param String $entityName
     * @param Integer $id
     * @param Integer $position
     * @throws NotFoundHttpException
     * @return Response
     *
     */
    public function sortAction($entityName, $id, $position)
    {
        $entity = $this->get('easyadmin.config.manager')->getEntityConfig($entityName);
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository($entity['class'])->find($id);
        if (is_null($e)) {
            throw new NotFoundHttpException("The entity was not found");
        }
        $e->setPosition($position);
        $em->persist($e);
        $em->flush();
        return $this->redirectToRoute(
            "easyadmin",
            array(
                "action" => "list",
                "entity" => $entityName,
                "sortField" => "position",
                "sortDirection" => "ASC",
            )
        );
    }
}
