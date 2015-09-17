<?php

namespace Weemen\BlogPost\Application\Command;


class EditBlogPost
{

    /**
     * @var string
     */
    public $blogPostId;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $author;

    /**
     * @var bool
     */
    public $published;

    /**
     * @var string
     */
    public $source;

    /**
     * @var string
     */
    public $publishDate;
}