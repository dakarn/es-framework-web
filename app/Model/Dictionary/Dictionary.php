<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.03.2018
 * Time: 17:38
 */

namespace App\Model\Dictionary;

class Dictionary
{
	private $id;

	private $text;

	private $translate;

	private $type;

	private $level;

	private $audioFile;

	public function __construct(array $data)
	{
		$this->id        = $data['id'] ?? 0;
		$this->text      = $data['text'] ?? '';
		$this->translate = $data['translate'] ?? '';
		$this->type      = $data['type'] ?? 0;
		$this->audioFile = $data['audioFile'] ?? '';
		$this->level     = $data['level'] ?? 0;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function getTranslate(): string
	{
		return $this->translate;
	}

	public function getType(): int
	{
		return $this->type;
	}

	public function getLevel()
	{
		return $this->level;
	}

	public function getAudioFile()
	{
		return $this->audioFile;
	}
}