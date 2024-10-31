<?php
/**
 * @package  contactFormPlugin
 */
namespace Inc;

final class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function rscf_getServices()
	{
		return [
			Pages\MessageDashboard::class,
			Base\MessageEnqueue::class,
			Base\MessageSettingsLinks::class,
			Base\MessageCommonController::class,
      		Base\MessageController::class,
      		Base\MessageAdminController::class,
      		Base\MessageAjaxController::class,
		];
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the rscf_registerServices() method if it exists
	 * @return
	 */
	public static function rscf_registerServices()
	{
		foreach (self::rscf_getServices() as $class) {
			$service = self::instantiate($class);
			if (method_exists($service, 'rscf_register')) {
				$service->rscf_register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private static function instantiate($class)
	{
		$service = new $class();

		return $service;
	}
}
