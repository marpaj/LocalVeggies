<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190128214457 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, firstname LONGTEXT NOT NULL, lastname LONGTEXT NOT NULL, address LONGTEXT NOT NULL, phone VARCHAR(50) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, cp INT NOT NULL, UNIQUE INDEX UNIQ_70E4FA78A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vegetable (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, variety LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE producer ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_976449DCA76ED395 ON producer (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, variety LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE vegetable');
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DCA76ED395');
        $this->addSql('DROP INDEX UNIQ_976449DCA76ED395 ON producer');
        $this->addSql('ALTER TABLE producer DROP user_id');
    }
}
