<?php

namespace BlogBundle\Controller;

use BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogController
 * @package BlogBundle\Controller
 */
class BlogController extends Controller
{
    /**
     * Blog index action.
     *
     * @return Response
     */
    public function indexAction()
    {
        $latestPosts = $this->getDoctrine()
            ->getRepository('BlogBundle:Post')
            ->findBy([], ['publishedAt' => 'DESC'], 3);

        return $this->render('BlogBundle:Blog:index.html.twig', [
            'posts' => $latestPosts,
        ]);
    }

    /**
     * Category detail action.
     *
     * @param string $categorySlug
     *
     * @return Response
     */
    public function categoryAction($categorySlug)
    {
        $repoCat = $this->getDoctrine()->getRepository('BlogBundle:Category');
        $category = $repoCat->findOneBySlug($categorySlug);

        if( null == $category) {
            throw $this->createNotFoundException('Cette catégorie n\'existe pas');
        }

        $repoPost = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $posts = $repoPost->findByCategory($category);

        return $this->render('BlogBundle:Blog:category.html.twig', [
            'category' => $category,
            'posts' => $posts
        ]);
    }

    /**
     * Post detail action.
     *
     * @param string $categorySlug
     * @param string $postSlug
     *
     * @return Response
     */
    public function postAction($categorySlug, $postSlug)
    {
        $repo = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $post = $repo->getPost($categorySlug, $postSlug);

        if( null == $post) {
            throw $this->createNotFoundException('Cet article n\'existe pas');
        }

        return $this->render('BlogBundle:Blog:post.html.twig', [
            'post' => $post
        ]);
    }
}
