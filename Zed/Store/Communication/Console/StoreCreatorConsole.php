<?php

namespace Pyz\Zed\Store\Communication\Console;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\Store\Business\StoreFacadeInterface getFacade()
 * @method \Spryker\Zed\Store\Communication\StoreCommunicationFactory getFactory()
 */
class StoreCreatorConsole extends Console
{
    public const COMMAND_NAME = 'store:create';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Create the Store';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getMessenger()->info('Create store');
        $storeTransfer = new StoreTransfer();
        $this->getFacade()->createStore($storeTransfer);

        return static::CODE_SUCCESS;
    }
}
