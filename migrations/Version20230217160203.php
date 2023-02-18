<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217160203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pro_sup DROP FOREIGN KEY FK_EB1876712ADD6D8C');
        $this->addSql('ALTER TABLE pro_sup DROP FOREIGN KEY FK_EB1876714584665A');
        $this->addSql('DROP TABLE pro_sup');
        $this->addSql('ALTER TABLE product ADD supplier_id INT DEFAULT NULL, DROP quantity');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD2ADD6D8C ON product (supplier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pro_sup (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, supplier_id INT DEFAULT NULL, date_to_deliver DATE NOT NULL, INDEX IDX_EB1876714584665A (product_id), INDEX IDX_EB1876712ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pro_sup ADD CONSTRAINT FK_EB1876712ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE pro_sup ADD CONSTRAINT FK_EB1876714584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2ADD6D8C');
        $this->addSql('DROP INDEX IDX_D34A04AD2ADD6D8C ON product');
        $this->addSql('ALTER TABLE product ADD quantity INT NOT NULL, DROP supplier_id');
    }
}
