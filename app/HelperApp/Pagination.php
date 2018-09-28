<?php

namespace App\HelperApp;

use Http\Request\ServerRequest;
use System\Database\DB;
use Traits\SingletonTrait;

class Pagination
{
	use SingletonTrait;

	/**
	 * @var int
	 */
	private $count_list = 3;

	/**
	 * @var
	 */
	private $page;

	/**
	 * @var int
	 */
	private $count = 0;

	/**
	 * @var array
	 */
	private $word = ['Назад', 'Далее'];

	/**
	 * @var
	 */
	private $url;

	/**
	 * @return bool
	 */
	public function isCorrectPage(): bool
	{
		return true;
	}

	/**
	 * @return int
	 */
	public function getPage(): int
	{
		return ServerRequest::create()->takeGet('page');
	}

	/**
	 * @param $count
	 * @return $this
	 */
	public function setCount($count): self
	{
		$this->count = $count;
		return $this;
	}

	/**
	 * @param $url
	 * @return $this
	 */
	public function setUrl($url): self
	{
		$this->url = $url;

		if (!isset($_GET['page'])) {
			$_GET['page'] = 1;
		}

		$this->page = abs($_GET['page']);

		if (empty($_GET['page'])) {
			$this->page = 1;
		}
		if (!isset($_GET['page'])) {
			$this->page = 1;
		}
		if (!empty($_GET['page']) && !is_numeric($_GET['page'])) {
			$this->page = 1;
		}

		return $this;
	}

	/**
	 * @param $countOnPage
	 * @return $this
	 */
	public function countOnPage($countOnPage): self
	{
		$this->count_list = $countOnPage;
		return $this;
	}

	/**
	 * @return array
	 */
	public function setData(): array
	{
		$offset = $this->count_list * ($this->page - 1);
		$data = [];

		$result = DB::create()->query('SELECT pageId, title, body, keywords, modified 
		FROM pet__page ORDER BY modified DESC LIMIT ' . $offset . ', ' . $this->count_list);

		while ($row = $result->fetch_object()) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * @return string
	 */
	public function next(): string
	{
		$link = '<button disabled class="btn btn-danger">' . $this->word[1] . '</button>';

		if ($this->page * $this->count_list < $this->count) {
			$link = '<a href="' . $this->url . 'page=' . ($this->page + 1) . '" class="btn btn-danger">' . $this->word[1] . '</a>';
		}

		return $link;
	}

	/**
	 * @return string
	 */
	public function prev(): string
	{
		$link = '<button disabled class="btn btn-danger">' . $this->word[0] . '</button>';

		if ($this->page > 1) {
			$link = '<a href="' . $this->url . 'page=' . ($this->page - 1) . '" class="btn btn-danger">' . $this->word[0] . '</a>';
		}

		return $link;
	}

}