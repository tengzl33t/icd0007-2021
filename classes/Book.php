<?php

class Book
{
    public int $id = 0;
    public string $title;
    public array $authors = [];
    public array $authors_ids = [];
    public int $mark;
    public int $read;

    public function __construct(string $title, int $mark, int $read)
    {
        $this->title = $title;
        $this->mark = $mark;
        $this->read = $read;
    }
}