<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\ReadModelInterface;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;

class BlogPostsPublishedSlugs implements ReadModelInterface
{

    /**
     * @var string
     */
    private $blogPostId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @param BlogPostId $blogPostId
     * @param string $title
     * @param string $content
     * @param string $author
     * @param string $source
     * @param DateTime $lastModified
     */
    public function __construct(BlogPostId $blogPostId, string $title, string $slug)
    {
        $this->blogPostId   = $blogPostId;
        $this->title        = $title;
        $this->slug         = $slug;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->blogPostId;
    }
}