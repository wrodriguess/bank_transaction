<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504115427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfer ADD payer_id INT NOT NULL, ADD payee_id INT NOT NULL');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0C17AD9A9 FOREIGN KEY (payer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0CB4B68F FOREIGN KEY (payee_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4034A3C0C17AD9A9 ON transfer (payer_id)');
        $this->addSql('CREATE INDEX IDX_4034A3C0CB4B68F ON transfer (payee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C0C17AD9A9');
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C0CB4B68F');
        $this->addSql('DROP INDEX IDX_4034A3C0C17AD9A9 ON transfer');
        $this->addSql('DROP INDEX IDX_4034A3C0CB4B68F ON transfer');
        $this->addSql('ALTER TABLE transfer ADD payer VARCHAR(255) NOT NULL, ADD payee VARCHAR(255) NOT NULL, DROP payer_id, DROP payee_id');
    }
}
