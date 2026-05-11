<?php

declare(strict_types=1);

namespace Mpemba\Crud\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260511100024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
         //   $this->addSql('ALTER TABLE group_menu ADD CONSTRAINT FK_GROUP_MENU_GROUP_ID FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
