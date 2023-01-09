<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116084827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, systems_id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value INT DEFAULT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_BC8617B0411D7F6D (systems_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C94D118B54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0411D7F6D FOREIGN KEY (systems_id) REFERENCES system (id)');
        $this->addSql('ALTER TABLE system ADD CONSTRAINT FK_C94D118B54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE system ADD tag INT NOT NULL');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0411D7F6D');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0411D7F6D411D7F6D FOREIGN KEY (systems_id) REFERENCES system (id) ON DELETE CASCADE');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room ADD is_stock TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD room_size INT NOT NULL, ADD windows_number INT NOT NULL, ADD type INT NOT NULL, ADD orientation VARCHAR(3) NOT NULL, ADD floor INT NOT NULL');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, temp_max INT NOT NULL, temp_min INT NOT NULL, hum_max INT NOT NULL, hum_min INT NOT NULL, co2_max INT NOT NULL, co2_min INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room CHANGE type type_id INT NOT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_729F519BC54C8C93 ON room (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0411D7F6D');
        $this->addSql('ALTER TABLE system DROP FOREIGN KEY FK_C94D118B54177093');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE system');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE system DROP tag');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0411D7F6D411D7F6D');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0411D7F6D FOREIGN KEY (systems_id) REFERENCES system (id)');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE room DROP is_stock');
        $this->addSql('ALTER TABLE room DROP room_size, DROP windows_number, DROP type, DROP orientation, DROP floor');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BC54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_729F519BC54C8C93 ON room');
        $this->addSql('ALTER TABLE room CHANGE type_id type INT NOT NULL');
    }
}
