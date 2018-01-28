<?php declare(strict_types=1);

namespace BaseApplication\Model;

use Zend\Hydrator\ClassMethods;

/**
 * Class SearchResult
 * @package BaseApplication\Model
 */
class SearchResult
{
    /**
     * @var string
     */
    private $title = '';

    /**
     * @var array
     */
    private $tableHeaderElements = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $controller = '';

    /**
     * @var string
     */
    private $route = '';

    /**
     * @var bool
     */
    private $showDeleteButton = false;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return SearchResult
     */
    public function setTitle(string $title): SearchResult
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getTableHeaderElements(): array
    {
        return $this->tableHeaderElements;
    }

    /**
     * @param array $tableHeaderElements
     * @return SearchResult
     */
    public function setTableHeaderElements(array $tableHeaderElements): SearchResult
    {
        $this->tableHeaderElements = $tableHeaderElements;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return SearchResult
     */
    public function setData(array $data): SearchResult
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     * @return SearchResult
     */
    public function setController(string $controller): SearchResult
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return SearchResult
     */
    public function setRoute(string $route): SearchResult
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowDeleteButton(): bool
    {
        return $this->showDeleteButton;
    }

    /**
     * @param bool $showDeleteButton
     * @return SearchResult
     */
    public function setShowDeleteButton(bool $showDeleteButton): SearchResult
    {
        $this->showDeleteButton = $showDeleteButton;
        return $this;
    }

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $hydrator = new ClassMethods(false);
            $hydrator->hydrate($data, $this);
        }
    }
}
