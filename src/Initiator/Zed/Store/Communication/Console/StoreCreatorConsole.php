<?php

namespace Initiator\Zed\Store\Communication\Console;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this->addArgument('store_name', InputArgument::REQUIRED, 'Enter a store-name in upper-case like: "DE"');
        $this->addArgument('default_locale_iso_code', InputArgument::REQUIRED, 'Enter a default country iso-code to use like: "de_DE"');
        $this->addArgument('currency_iso_code', InputArgument::REQUIRED, 'Enter a currency iso code in upper-case like: "EUR"');
        $this->addOption('countries', 'c', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Enter a countries to use like: "--c DE --c AT"');
        $this->addOption('available_currency_iso_codes', 'acic', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Enter a countries to use like: "--acic EUR --acic CHF"');
        $this->addOption('available_locale_iso_codes', 'alic', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Enter a countries to use like: "--alic de_DE --alic de_AT"');

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
