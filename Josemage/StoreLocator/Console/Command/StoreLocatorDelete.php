<?php

namespace Josemage\StoreLocator\Console\Command;

use Josemage\StoreLocator\Action\DeleteStoreLocatorAction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class StoreLocatorDelete extends Command
{
    const ARG_NAME_ORDER_ID = 'locator-id';
    /**
     * @var DeleteStoreLocatorAction
     */
    private DeleteStoreLocatorAction $deleteStoreLocatorAction;

    /**
     * @param string|null $name
     */
    public function __construct(
        DeleteStoreLocatorAction $deleteStoreLocatorAction,
        string                   $name = null
    )
    {
        parent::__construct($name);
        $this->deleteStoreLocatorAction = $deleteStoreLocatorAction;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('store:locator:delete');
        $this->setDescription('Delete store locator')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                "Store Locator Id"
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $id = $input->getArgument(self::ARG_NAME_ORDER_ID);

        $result = $this->deleteStoreLocatorAction->execute($id);
        $success = $result['success'] ?? false;
        if ($success) {
            $output->writeln(__('Successfully Store Locator deleted'));
        } else {
            $msg = $result['error'] ?? null;
            if ($msg === null) {
                $msg = __('Unexpected errors occurred');
            }
            $output->writeln($msg);
            return 1;
        }

        return 0;
    }


}
