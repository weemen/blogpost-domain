<?php

namespace Weemen\BlogPost\Domain\BlogPost;


use DateTime;

class BlogPostEdited
{

    /**
     * @var BlogPostId
     */
    protected $blogPostId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $author;


    /**
     * @var bool
     */
    protected $published;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $publishDate;

    /**
     * @param BlogPostId $blogPostId
     * @param string $title
     * @param string $content
     * @param string $author
     */
    public function __construct(BlogPostId $blogPostId, string $title, string $content, string $author, bool $published, string $source, string $publishDate)
    {
        $this->blogPostId  = $blogPostId;
        $this->title       = $title;
        $this->content     = $content;
        $this->author      = $author;
        $this->published   = $published;
        $this->source      = $source;
        $this->publishDate = $publishDate;
    }

    /**
     * @return BlogPostId
     */
    public function blogPostId() : BlogPostId
    {
        return $this->blogPostId;
    }

    /**
     * @return string|string
     */
    public function title() : string
    {
        return $this->title;
    }

    /**
     * @return string|string
     */
    public function content() : string
    {
        return $this->content;
    }

    /**
     * @return string|string
     */
    public function author() : string
    {
        return $this->author;
    }

    /**
     * @return bool|bool
     */
    public function published() : bool
    {
        return $this->published;
    }

    /**
     * @return string|string
     */
    public function source() : string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function publishDate() : string
    {
        return $this->publishDate;
    }
}