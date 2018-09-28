<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2018
 * Time: 15:04
 */

/**
 * Class SocialsManager
 */
final class SocialsManager
{
	/**
	 * @var array
	 */
	const SETTING_VK = [
		'secureKey'  => 'k4MZ4My8hEGRmn2oO1bN',
		'serviceKey' => '672d3a91672d3a91672d3a91a2674ddc4d6672d672d3a913d43285ac910e55b08ab1f33',
		'appID'      => '6350556'
	];

	/**
	 * @var array
	 */
	const SETTING_MAIL = [
		'secureKey'  => 'k4MZ4My8hEGRmn2oO1bN',
		'serviceKey' => '672d3a91672d3a91672d3a91a2674ddc4d6672d672d3a913d43285ac910e55b08ab1f33',
		'appID'      => '6350556'
	];

	/**
	 * @var SocialsManager
	 */
	public static $instance;

	/**
	 * @var VK $vk
	 */
	private $vk;

	/**
	 * @var Mail mail
	 */
	private $mail;

	/**
	 * @var GooglePlus google
	 */
	private $google;

	/**
	 * @return SocialsManager|static
	 */
	public static function create()
	{
		if (!self::$instance instanceof SocialsManager) {
			self::$instance = new static;
		}

		return self::$instance;
	}

	private function __construct()
	{
	}

	/**
	 * @return VK
	 */
	public function getVK(): VK
	{
		if (!$this->vk instanceof VK) {
			$this->vk = new VK(self::SETTING_VK);
		}

		return $this->vk;
	}

	/**
	 * @return GooglePlus
	 */
	public function getGooglePlus(): GooglePlus
	{
		if (!$this->google instanceof GooglePlus) {
			$this->google = new GooglePlus(self::SETTING_VK);
		}

		return $this->google;
	}

	/**
	 * @return Mail
	 */
	public function getMail(): Mail
	{
		if (!$this->mail instanceof Mail) {
			$this->mail = new Mail(self::SETTING_MAIL);
		}

		return $this->mail;
	}
}