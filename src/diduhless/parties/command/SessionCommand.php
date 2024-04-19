<?php


namespace diduhless\parties\command;


use diduhless\parties\Parties;
use diduhless\parties\session\Session;
use diduhless\parties\session\SessionFactory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

abstract class SessionCommand extends Command implements PluginOwned {

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []) {
        $this->setPermission(DefaultPermissions::ROOT_USER);
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if($sender instanceof Player and SessionFactory::hasSession($sender)) {
            $this->onCommand(SessionFactory::getSession($sender), $args);
        }
    }

    abstract public function onCommand(Session $session, array $args): void;

    public function getOwningPlugin(): Plugin {
        return Parties::getInstance();
    }

}