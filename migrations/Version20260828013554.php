<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260828013554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nexo_account ADD CONSTRAINT FK_912DA0AA9395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_account ADD CONSTRAINT FK_912DA0AAC6798DB FOREIGN KEY (account_type_id) REFERENCES nexo_account_type (id)');
        $this->addSql('ALTER TABLE nexo_account ADD CONSTRAINT FK_912DA0AAF4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE nexo_alert ADD CONSTRAINT FK_141C25899395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_card ADD variante VARCHAR(255) DEFAULT NULL, ADD gauge_color VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE nexo_card ADD CONSTRAINT FK_4195DC519395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_card ADD CONSTRAINT FK_4195DC51925606E5 FOREIGN KEY (card_type_id) REFERENCES nexo_card_type (id)');
        $this->addSql('ALTER TABLE nexo_card ADD CONSTRAINT FK_4195DC51F4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE nexo_category_expense_customer ADD CONSTRAINT FK_57F45CF1F4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE nexo_category_expense_customer ADD CONSTRAINT FK_57F45CF112469DE2 FOREIGN KEY (category_id) REFERENCES nexo_category_expense (id)');
        $this->addSql('ALTER TABLE nexo_category_expense_customer ADD CONSTRAINT FK_57F45CF19395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_crypto_address ADD CONSTRAINT FK_C45F102414302A7C FOREIGN KEY (crypto_type_id) REFERENCES nexo_crypto_type (id)');
        $this->addSql('ALTER TABLE nexo_customer ADD CONSTRAINT FK_666DB8F8A76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nexo_customer ADD CONSTRAINT FK_666DB8F8C836AEF2 FOREIGN KEY (flashy_id) REFERENCES nexo_flashy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nexo_customer_crypto_address ADD CONSTRAINT FK_1255B4D99395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_customer_crypto_address ADD CONSTRAINT FK_1255B4D914302A7C FOREIGN KEY (crypto_type_id) REFERENCES nexo_crypto_type (id)');
        $this->addSql('ALTER TABLE nexo_deposit_crypto ADD CONSTRAINT FK_61CEAC8EA76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_deposit_crypto ADD CONSTRAINT FK_61CEAC8E14302A7C FOREIGN KEY (crypto_type_id) REFERENCES nexo_crypto_type (id)');
        $this->addSql('ALTER TABLE nexo_external_account ADD CONSTRAINT FK_510D5A759395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_external_account ADD CONSTRAINT FK_510D5A7537E080D9 FOREIGN KEY (banque_id) REFERENCES nexo_banque (id)');
        $this->addSql('ALTER TABLE nexo_external_account ADD CONSTRAINT FK_510D5A75F92F3E70 FOREIGN KEY (country_id) REFERENCES nexo_country (id)');
        $this->addSql('ALTER TABLE nexo_identity_document ADD CONSTRAINT FK_8576BD021623CB0A FOREIGN KEY (verification_id) REFERENCES nexo_identity_verification (id)');
        $this->addSql('ALTER TABLE nexo_identity_verification ADD CONSTRAINT FK_47082202A76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_message ADD CONSTRAINT FK_5AA6C6719395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_transaction ADD CONSTRAINT FK_232B1849F4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE nexo_transaction ADD CONSTRAINT FK_232B18499395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_transaction ADD CONSTRAINT FK_232B18499B6B5FBA FOREIGN KEY (account_id) REFERENCES nexo_account (id)');
        $this->addSql('ALTER TABLE nexo_transaction ADD CONSTRAINT FK_232B1849FE347F57 FOREIGN KEY (trans_type_id) REFERENCES nexo_type_transaction (id)');
        $this->addSql('ALTER TABLE nexo_transaction ADD CONSTRAINT FK_232B184912469DE2 FOREIGN KEY (category_id) REFERENCES nexo_category_expense (id)');
        $this->addSql('ALTER TABLE nexo_user ADD CONSTRAINT FK_DA1292CB82F1BAF4 FOREIGN KEY (language_id) REFERENCES nexo_langue (id)');
        $this->addSql('ALTER TABLE nexo_user ADD CONSTRAINT FK_DA1292CBF4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto ADD CONSTRAINT FK_594CC282A76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto ADD CONSTRAINT FK_594CC28214302A7C FOREIGN KEY (crypto_type_id) REFERENCES nexo_crypto_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nexo_account DROP FOREIGN KEY FK_912DA0AA9395C3F3');
        $this->addSql('ALTER TABLE nexo_account DROP FOREIGN KEY FK_912DA0AAC6798DB');
        $this->addSql('ALTER TABLE nexo_account DROP FOREIGN KEY FK_912DA0AAF4445056');
        $this->addSql('ALTER TABLE nexo_alert DROP FOREIGN KEY FK_141C25899395C3F3');
        $this->addSql('ALTER TABLE nexo_card DROP FOREIGN KEY FK_4195DC519395C3F3');
        $this->addSql('ALTER TABLE nexo_card DROP FOREIGN KEY FK_4195DC51925606E5');
        $this->addSql('ALTER TABLE nexo_card DROP FOREIGN KEY FK_4195DC51F4445056');
        $this->addSql('ALTER TABLE nexo_card DROP variante, DROP gauge_color');
        $this->addSql('ALTER TABLE nexo_category_expense_customer DROP FOREIGN KEY FK_57F45CF1F4445056');
        $this->addSql('ALTER TABLE nexo_category_expense_customer DROP FOREIGN KEY FK_57F45CF112469DE2');
        $this->addSql('ALTER TABLE nexo_category_expense_customer DROP FOREIGN KEY FK_57F45CF19395C3F3');
        $this->addSql('ALTER TABLE nexo_crypto_address DROP FOREIGN KEY FK_C45F102414302A7C');
        $this->addSql('ALTER TABLE nexo_customer DROP FOREIGN KEY FK_666DB8F8A76ED395');
        $this->addSql('ALTER TABLE nexo_customer DROP FOREIGN KEY FK_666DB8F8C836AEF2');
        $this->addSql('ALTER TABLE nexo_customer_crypto_address DROP FOREIGN KEY FK_1255B4D99395C3F3');
        $this->addSql('ALTER TABLE nexo_customer_crypto_address DROP FOREIGN KEY FK_1255B4D914302A7C');
        $this->addSql('ALTER TABLE nexo_deposit_crypto DROP FOREIGN KEY FK_61CEAC8EA76ED395');
        $this->addSql('ALTER TABLE nexo_deposit_crypto DROP FOREIGN KEY FK_61CEAC8E14302A7C');
        $this->addSql('ALTER TABLE nexo_external_account DROP FOREIGN KEY FK_510D5A759395C3F3');
        $this->addSql('ALTER TABLE nexo_external_account DROP FOREIGN KEY FK_510D5A7537E080D9');
        $this->addSql('ALTER TABLE nexo_external_account DROP FOREIGN KEY FK_510D5A75F92F3E70');
        $this->addSql('ALTER TABLE nexo_identity_document DROP FOREIGN KEY FK_8576BD021623CB0A');
        $this->addSql('ALTER TABLE nexo_identity_verification DROP FOREIGN KEY FK_47082202A76ED395');
        $this->addSql('ALTER TABLE nexo_message DROP FOREIGN KEY FK_5AA6C6719395C3F3');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B1849F4445056');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B18499395C3F3');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B18499B6B5FBA');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B1849FE347F57');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B184912469DE2');
        $this->addSql('ALTER TABLE nexo_user DROP FOREIGN KEY FK_DA1292CB82F1BAF4');
        $this->addSql('ALTER TABLE nexo_user DROP FOREIGN KEY FK_DA1292CBF4445056');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto DROP FOREIGN KEY FK_594CC282A76ED395');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto DROP FOREIGN KEY FK_594CC28214302A7C');
    }
}
