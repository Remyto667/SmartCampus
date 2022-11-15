<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115165029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BD0952FA5');
        $this->addSql('DROP INDEX UNIQ_729F519BD0952FA5 ON room');
        $this->addSql('ALTER TABLE room DROP system_id');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0D0952FA5');
        $this->addSql('DROP INDEX UNIQ_BC8617B0D0952FA5 ON sensor');
        $this->addSql('ALTER TABLE sensor ADD systems_id INT NOT NULL, DROP system_id');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0411D7F6D FOREIGN KEY (systems_id) REFERENCES `system` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BC8617B0411D7F6D ON sensor (systems_id)');
        $this->addSql('ALTER TABLE system ADD room_id INT NOT NULL');
        $this->addSql('ALTER TABLE system ADD CONSTRAINT FK_C94D118B54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C94D118B54177093 ON system (room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `system` DROP FOREIGN KEY FK_C94D118B54177093');
        $this->addSql('DROP INDEX UNIQ_C94D118B54177093 ON `system`');
        $this->addSql('ALTER TABLE `system` DROP room_id');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0411D7F6D');
        $this->addSql('DROP INDEX UNIQ_BC8617B0411D7F6D ON sensor');
        $this->addSql('ALTER TABLE sensor ADD system_id INT DEFAULT NULL, DROP systems_id');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0D0952FA5 FOREIGN KEY (system_id) REFERENCES system (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BC8617B0D0952FA5 ON sensor (system_id)');
        $this->addSql('ALTER TABLE room ADD system_id INT NOT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BD0952FA5 FOREIGN KEY (system_id) REFERENCES system (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_729F519BD0952FA5 ON room (system_id)');
    }
}
