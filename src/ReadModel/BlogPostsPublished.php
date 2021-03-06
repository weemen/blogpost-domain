<?php

namespace Weemen\BlogPost\ReadModel;


use Broadway\ReadModel\ReadModelInterface;
use DateTime;
use Weemen\BlogPost\Domain\BlogPost\BlogPostId;

class BlogPostsPublished implements ReadModelInterface
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

    /**
     * @var int
     */
    private $publishDate;

    /**
     * @param BlogPostId $blogPostId
     * @param string $title
     * @param string $content
     * @param string $author
     * @param string $source
     * @param DateTime $lastModified
     * @param int $publishDate
     */
    public function __construct(BlogPostId $blogPostId, string $title, string $content, string $author, string $source, DateTime $lastModified, int $publishDate)
    {
        $this->blogPostId   = $blogPostId;
        $this->title        = $title;
        $this->content      = $content;
        $this->author       = $author;
        $this->source       = $source;
        $this->lastModified = $lastModified;
        $this->publishDate  = $publishDate;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->blogPostId;
    }

}