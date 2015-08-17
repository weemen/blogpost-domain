<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\ReadModelInterface;
use DateTime;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;

class BlogPostsPublished implements ReadModelInterface
{
    /**
     * @var int
     */
    private $id;

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
    private $content;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $source;

    /**
     * @var DateTime
     */
    private $lastModified;

    public function __construct(BlogPostId $blogPostId, string $title, string $content, string $author, string $source, DateTime $lastModified)
    {
        $this->blogPostId   = $blogPostId;
        $this->title        = $title;
        $this->content      = $content;
        $this->author       = $author;
        $this->source       = $source;
        $this->lastModified = $lastModified->format('d-m-Y H:i:s');
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}