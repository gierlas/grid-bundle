<?php

namespace Kora\GridBundle;

use Kora\GridBundle\DependencyInjection\KoraGridExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class KoraGridBundle
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class KoraGridBundle extends Bundle
{
	/**
	 * @inheritdoc
	 */
	public function getContainerExtension()
	{
		if (null === $this->extension) {
			$this->extension = new KoraGridExtension();
		}

		return $this->extension;
	}
}