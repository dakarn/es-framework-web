<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2018
 * Time: 15:44
 */

abstract class AbstractSocials implements SocialsInterface
{
	/**
	 * @var array
	 */
	protected $properties;

	/**
	 * @var string
	 */
	protected $login;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var string
	 */
	protected $firstName;

	/**
	 * @var string
	 */
	protected $lastName;

	/**
	 * @var bool
	 */
	protected $wasAuthorized = false;

	/**
	 * AbstractSocials constructor.
	 * @param array $properties
	 */
	public function __construct(array $properties)
	{
		$this->properties = $properties;
	}

	/**
	 * @return string
	 */
	public  function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * @return string
	 */
	public  function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @return string
	 */
	public  function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string|null $key
	 * @return array|mixed
	 */
	public function getData(string $key = null)
	{
		if (empty($key)) {
			return $this->data;
		}

		return isset($this->data[$key]) ? $this->data[$key] : $this->data;
	}

	/**
	 * @return $this
	 */
	public function fetch()
	{
		$this->_fetch();
		return $this;
	}

	public function getToken()
	{

	}

	public function auth()
	{
		if (!$this->wasAuthorized) {
			$this->_auth();
		}

		return $this;
	}
}