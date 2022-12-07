<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207080749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0411D7F6D');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0411D7F6D411D7F6D FOREIGN KEY (systems_id) REFERENCES system (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0411D7F6D411D7F6D');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0411D7F6D FOREIGN KEY (systems_id) REFERENCES system (id)');
    }
}
