<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217075758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY cart_ibfk_2');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY cart_ibfk_3');
        $this->addSql('ALTER TABLE orderdetail DROP FOREIGN KEY orderdetail_ibfk_1');
        $this->addSql('ALTER TABLE orderdetail DROP FOREIGN KEY orderdetail_ibfk_2');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE orderdetail');
        $this->addSql('ALTER TABLE category CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE description descriptions VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX username ON `order`');
        $this->addSql('ALTER TABLE `order` ADD date_discount DATETIME NOT NULL, ADD price_dicount NUMERIC(10, 2) NOT NULL, DROP date, DROP delivery_date, DROP cust_name, DROP cust_phone, DROP total, DROP status, DROP username, CHANGE delivery_local voucher VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pro_size ADD CONSTRAINT FK_27E091184584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pro_size ADD CONSTRAINT FK_27E09118498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE pro_sup ADD CONSTRAINT FK_EB1876714584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pro_sup ADD CONSTRAINT FK_EB1876712ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY product_ibfk_2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY product_ibfk_1');
        $this->addSql('DROP INDEX sup_id ON product');
        $this->addSql('DROP INDEX cate_id ON product');
        $this->addSql('ALTER TABLE product ADD category_id INT DEFAULT NULL, DROP cate_id, DROP sup_id, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE price price NUMERIC(10, 2) NOT NULL, CHANGE description descriptions VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('ALTER TABLE supplier ADD email VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE phone phone INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD id INT AUTO_INCREMENT NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD phone_number INT NOT NULL, DROP username, DROP firstName, DROP lastName, DROP telephone, DROP role, CHANGE password password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE birthday day_of_birth DATE NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (cart_id INT AUTO_INCREMENT NOT NULL, username VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, pid VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, pcount INT NOT NULL, INDEX pid (pid), INDEX username (username), PRIMARY KEY(cart_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE orderdetail (order_id INT NOT NULL, pro_id VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, quantity INT NOT NULL, INDEX pro_id (pro_id), INDEX order_id (order_id), PRIMARY KEY(order_id, pro_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT cart_ibfk_2 FOREIGN KEY (pid) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT cart_ibfk_3 FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderdetail ADD CONSTRAINT orderdetail_ibfk_1 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderdetail ADD CONSTRAINT orderdetail_ibfk_2 FOREIGN KEY (pro_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category CHANGE id id VARCHAR(10) NOT NULL, CHANGE name name VARCHAR(20) NOT NULL, CHANGE descriptions description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD delivery_date DATETIME NOT NULL, ADD cust_name VARCHAR(50) NOT NULL, ADD cust_phone VARCHAR(12) NOT NULL, ADD total NUMERIC(8, 0) NOT NULL, ADD status TINYINT(1) NOT NULL, ADD username VARCHAR(10) NOT NULL, DROP price_dicount, CHANGE date_discount date DATETIME NOT NULL, CHANGE voucher delivery_local VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX username ON `order` (username)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product ADD cate_id VARCHAR(10) NOT NULL, ADD sup_id VARCHAR(10) NOT NULL, DROP category_id, CHANGE id id VARCHAR(10) NOT NULL, CHANGE name name VARCHAR(50) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE descriptions description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT product_ibfk_2 FOREIGN KEY (sup_id) REFERENCES supplier (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT product_ibfk_1 FOREIGN KEY (cate_id) REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX sup_id ON product (sup_id)');
        $this->addSql('CREATE INDEX cate_id ON product (cate_id)');
        $this->addSql('ALTER TABLE pro_size DROP FOREIGN KEY FK_27E091184584665A');
        $this->addSql('ALTER TABLE pro_size DROP FOREIGN KEY FK_27E09118498DA827');
        $this->addSql('ALTER TABLE pro_sup DROP FOREIGN KEY FK_EB1876714584665A');
        $this->addSql('ALTER TABLE pro_sup DROP FOREIGN KEY FK_EB1876712ADD6D8C');
        $this->addSql('ALTER TABLE supplier DROP email, CHANGE id id VARCHAR(10) NOT NULL, CHANGE name name VARCHAR(20) NOT NULL, CHANGE phone phone VARCHAR(12) NOT NULL');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('DROP INDEX `PRIMARY` ON user');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(10) NOT NULL, ADD firstName VARCHAR(15) NOT NULL, ADD lastName VARCHAR(20) NOT NULL, ADD telephone VARCHAR(12) NOT NULL, ADD role TINYINT(1) NOT NULL, DROP id, DROP roles, DROP phone_number, CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(50) NOT NULL, CHANGE day_of_birth birthday DATE NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (username)');
    }
}
