<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260827135317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE identity_document (id BINARY(16) NOT NULL, type VARCHAR(255) NOT NULL, original_name VARCHAR(255) DEFAULT NULL, stored_name VARCHAR(100) DEFAULT NULL, mime_type VARCHAR(100) DEFAULT NULL, size INT DEFAULT NULL, checksum VARCHAR(64) NOT NULL, uploaded_at DATETIME NOT NULL, verification_id BINARY(16) DEFAULT NULL, INDEX IDX_9B82D6BF1623CB0A (verification_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE identity_verification (id BINARY(16) NOT NULL, status VARCHAR(255) NOT NULL, iban_encrypted LONGTEXT DEFAULT NULL, iban_last4 VARCHAR(4) DEFAULT NULL, bic VARCHAR(11) DEFAULT NULL, rejection_reason VARCHAR(500) DEFAULT NULL, submitted_at DATETIME DEFAULT NULL, reviewed_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, user_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_664D895EA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_account (id BINARY(16) NOT NULL, label VARCHAR(255) NOT NULL, principal TINYINT DEFAULT NULL, account_number VARCHAR(14) DEFAULT NULL, growth_this_month NUMERIC(14, 2) NOT NULL, status VARCHAR(255) NOT NULL, amount NUMERIC(14, 2) DEFAULT NULL, pending_amount NUMERIC(14, 2) DEFAULT NULL, outgoing_amount NUMERIC(14, 2) DEFAULT NULL, blocked_amount NUMERIC(14, 2) DEFAULT NULL, incoming_amount NUMERIC(14, 2) DEFAULT NULL, saving_amount NUMERIC(14, 2) DEFAULT NULL, iban VARCHAR(255) DEFAULT NULL, iban_formatted VARCHAR(255) DEFAULT NULL, tag VARCHAR(100) DEFAULT NULL, category VARCHAR(34) DEFAULT NULL, bic VARCHAR(11) DEFAULT NULL, cle_rib VARCHAR(5) DEFAULT NULL, code_banque VARCHAR(5) DEFAULT NULL, code_guichet VARCHAR(5) DEFAULT NULL, creation_date DATETIME DEFAULT NULL, modification_date DATETIME DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, account_type_id BINARY(16) DEFAULT NULL, devise_id BINARY(16) DEFAULT NULL, INDEX IDX_912DA0AA9395C3F3 (customer_id), INDEX IDX_912DA0AAC6798DB (account_type_id), INDEX IDX_912DA0AAF4445056 (devise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_account_type (id BINARY(16) NOT NULL, label VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, advantages LONGTEXT DEFAULT NULL, plafond NUMERIC(14, 2) DEFAULT NULL, tag VARCHAR(50) DEFAULT NULL, devise VARCHAR(50) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_alert (id BINARY(16) NOT NULL, label VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, amount NUMERIC(14, 2) DEFAULT NULL, devise VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, `read` TINYINT DEFAULT NULL, date DATETIME DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, INDEX IDX_141C25899395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_banque (id BINARY(16) NOT NULL, label VARCHAR(191) DEFAULT NULL, country_iso VARCHAR(50) DEFAULT NULL, code_banque VARCHAR(20) DEFAULT NULL, code_swift VARCHAR(20) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_card (id BINARY(16) NOT NULL, label VARCHAR(255) DEFAULT NULL, sub_label VARCHAR(255) DEFAULT NULL, percent_used INT DEFAULT NULL, card_number VARCHAR(255) DEFAULT NULL, card_number_mask VARCHAR(255) DEFAULT NULL, amount NUMERIC(14, 2) DEFAULT NULL, expire_month VARCHAR(255) DEFAULT NULL, expire VARCHAR(255) DEFAULT NULL, expire_year VARCHAR(255) DEFAULT NULL, is_principal TINYINT DEFAULT NULL, amount_expended_this_monthly NUMERIC(14, 2) DEFAULT NULL, cvv VARCHAR(4) DEFAULT NULL, status VARCHAR(255) NOT NULL, limit_exceeded TINYINT DEFAULT NULL, holder VARCHAR(191) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, card_type_id BINARY(16) DEFAULT NULL, devise_id BINARY(16) DEFAULT NULL, INDEX IDX_4195DC519395C3F3 (customer_id), INDEX IDX_4195DC51925606E5 (card_type_id), INDEX IDX_4195DC51F4445056 (devise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_card_type (id BINARY(16) NOT NULL, label VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, advantages LONGTEXT DEFAULT NULL, tag VARCHAR(50) DEFAULT NULL, currency_iso VARCHAR(50) DEFAULT NULL, amount NUMERIC(14, 2) DEFAULT NULL, spend_by_month NUMERIC(14, 2) DEFAULT NULL, spend_by_day NUMERIC(14, 2) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_category_expense (id BINARY(16) NOT NULL, label VARCHAR(100) DEFAULT NULL, tag VARCHAR(100) DEFAULT NULL, color VARCHAR(100) DEFAULT NULL, active TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_category_expense_customer (id BINARY(16) NOT NULL, amount NUMERIC(14, 2) NOT NULL, devise_id BINARY(16) DEFAULT NULL, category_id BINARY(16) DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, INDEX IDX_57F45CF1F4445056 (devise_id), INDEX IDX_57F45CF112469DE2 (category_id), INDEX IDX_57F45CF19395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_country (id BINARY(16) NOT NULL, label VARCHAR(100) DEFAULT NULL, code_iso2 VARCHAR(2) DEFAULT NULL, code_iso3 VARCHAR(3) DEFAULT NULL, country_code VARCHAR(10) DEFAULT NULL, language VARCHAR(10) DEFAULT NULL, currency_iso VARCHAR(5) DEFAULT NULL, time_zone VARCHAR(50) DEFAULT NULL, continent VARCHAR(50) DEFAULT NULL, flag VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_crypto_address (id BINARY(16) NOT NULL, address VARCHAR(191) DEFAULT NULL, active TINYINT DEFAULT NULL, created_at DATETIME DEFAULT NULL, crypto_type_id BINARY(16) DEFAULT NULL, INDEX IDX_C45F102414302A7C (crypto_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_crypto_type (id BINARY(16) NOT NULL, label VARCHAR(255) DEFAULT NULL, tag VARCHAR(50) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_customer (id BINARY(16) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, date_obirth DATETIME DEFAULT NULL, country_of_birth VARCHAR(59) DEFAULT NULL, salary_devise VARCHAR(59) DEFAULT NULL, nationality VARCHAR(50) DEFAULT NULL, address VARCHAR(500) DEFAULT NULL, postal_code VARCHAR(50) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, identity_photo VARCHAR(255) DEFAULT NULL, card_id_type VARCHAR(255) DEFAULT NULL, card_id_number VARCHAR(255) DEFAULT NULL, card_id_expired_date DATETIME DEFAULT NULL, salary NUMERIC(14, 2) DEFAULT NULL, employment_type VARCHAR(50) DEFAULT NULL, marital_status VARCHAR(255) DEFAULT NULL, phone_country_code VARCHAR(50) DEFAULT NULL, phone_number VARCHAR(50) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, user_id BINARY(16) NOT NULL, flashy_id BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_666DB8F8A76ED395 (user_id), UNIQUE INDEX UNIQ_666DB8F8C836AEF2 (flashy_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_customer_crypto_address (id BINARY(16) NOT NULL, address VARCHAR(191) DEFAULT NULL, label VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, crypto_type_id BINARY(16) DEFAULT NULL, INDEX IDX_1255B4D99395C3F3 (customer_id), INDEX IDX_1255B4D914302A7C (crypto_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_deposit_crypto (id BINARY(16) NOT NULL, address VARCHAR(191) DEFAULT NULL, amount NUMERIC(18, 8) DEFAULT NULL, status VARCHAR(255) NOT NULL, tx_hash VARCHAR(191) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id BINARY(16) DEFAULT NULL, crypto_type_id BINARY(16) DEFAULT NULL, INDEX IDX_61CEAC8EA76ED395 (user_id), INDEX IDX_61CEAC8E14302A7C (crypto_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_devise (id BINARY(16) NOT NULL, country_iso VARCHAR(50) DEFAULT NULL, label VARCHAR(50) DEFAULT NULL, code_iso VARCHAR(5) DEFAULT NULL, symbol VARCHAR(5) DEFAULT NULL, active TINYINT DEFAULT NULL, user_id BINARY(16) DEFAULT NULL, INDEX IDX_3BE98C1EA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_external_account (id BINARY(16) NOT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, gender VARCHAR(50) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, bic_swift VARCHAR(11) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, banque_id BINARY(16) DEFAULT NULL, country_id BINARY(16) NOT NULL, INDEX IDX_510D5A759395C3F3 (customer_id), INDEX IDX_510D5A7537E080D9 (banque_id), INDEX IDX_510D5A75F92F3E70 (country_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_flashy (id BINARY(16) NOT NULL, alert_type VARCHAR(255) NOT NULL, message VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, `show` TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_langue (id BINARY(16) NOT NULL, label VARCHAR(50) DEFAULT NULL, code_iso VARCHAR(10) DEFAULT NULL, active TINYINT DEFAULT NULL, user_id BINARY(16) DEFAULT NULL, INDEX IDX_EB535D4FA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_message (id BINARY(16) NOT NULL, label VARCHAR(50) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, `read` TINYINT DEFAULT NULL, date DATETIME DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, INDEX IDX_5AA6C6719395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_settings (name VARCHAR(80) NOT NULL, value LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (name)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `nexo_transaction` (id BINARY(16) NOT NULL, amount NUMERIC(14, 2) NOT NULL, trans_date DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, operation VARCHAR(255) NOT NULL, metadata JSON DEFAULT NULL, reference VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, holder VARCHAR(191) DEFAULT NULL, created_at DATETIME DEFAULT NULL, devise_id BINARY(16) DEFAULT NULL, customer_id BINARY(16) DEFAULT NULL, account_id BINARY(16) DEFAULT NULL, trans_type_id BINARY(16) DEFAULT NULL, category_id BINARY(16) DEFAULT NULL, INDEX IDX_232B1849F4445056 (devise_id), INDEX IDX_232B18499395C3F3 (customer_id), INDEX IDX_232B18499B6B5FBA (account_id), INDEX IDX_232B1849FE347F57 (trans_type_id), INDEX IDX_232B184912469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_type_transaction (id BINARY(16) NOT NULL, label VARCHAR(191) DEFAULT NULL, active TINYINT DEFAULT NULL, icon_svg LONGTEXT DEFAULT NULL, icon_png VARCHAR(255) DEFAULT NULL, icon_code VARCHAR(50) DEFAULT NULL, is_icon_code TINYINT DEFAULT NULL, bg_icon_color VARCHAR(20) DEFAULT NULL, text_icon_color VARCHAR(20) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_user (id BINARY(16) NOT NULL, identifier VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, password_attemp_count INT DEFAULT NULL, two_factor_enable TINYINT DEFAULT NULL, identity_confirmed TINYINT DEFAULT NULL, loan_activated TINYINT DEFAULT NULL, investment_activated TINYINT DEFAULT NULL, validation_code VARCHAR(255) DEFAULT NULL, last_login_from VARCHAR(255) DEFAULT NULL, last_login_ip_address VARCHAR(255) DEFAULT NULL, validation_date DATETIME DEFAULT NULL, virement_percent NUMERIC(14, 2) DEFAULT NULL, virement_code INT DEFAULT NULL, virement_message VARCHAR(500) DEFAULT NULL, validation_attempt_count INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, roles JSON NOT NULL, last_login_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE nexo_withdraw_crypto (id BINARY(16) NOT NULL, to_address VARCHAR(191) DEFAULT NULL, amount NUMERIC(18, 8) DEFAULT NULL, status VARCHAR(255) NOT NULL, tx_hash VARCHAR(191) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, user_id BINARY(16) DEFAULT NULL, crypto_type_id BINARY(16) DEFAULT NULL, INDEX IDX_594CC282A76ED395 (user_id), INDEX IDX_594CC28214302A7C (crypto_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE identity_document ADD CONSTRAINT FK_9B82D6BF1623CB0A FOREIGN KEY (verification_id) REFERENCES identity_verification (id)');
        $this->addSql('ALTER TABLE identity_verification ADD CONSTRAINT FK_664D895EA76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_account ADD CONSTRAINT FK_912DA0AA9395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_account ADD CONSTRAINT FK_912DA0AAC6798DB FOREIGN KEY (account_type_id) REFERENCES nexo_account_type (id)');
        $this->addSql('ALTER TABLE nexo_account ADD CONSTRAINT FK_912DA0AAF4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE nexo_alert ADD CONSTRAINT FK_141C25899395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
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
        $this->addSql('ALTER TABLE nexo_devise ADD CONSTRAINT FK_3BE98C1EA76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_external_account ADD CONSTRAINT FK_510D5A759395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE nexo_external_account ADD CONSTRAINT FK_510D5A7537E080D9 FOREIGN KEY (banque_id) REFERENCES nexo_banque (id)');
        $this->addSql('ALTER TABLE nexo_external_account ADD CONSTRAINT FK_510D5A75F92F3E70 FOREIGN KEY (country_id) REFERENCES nexo_country (id)');
        $this->addSql('ALTER TABLE nexo_langue ADD CONSTRAINT FK_EB535D4FA76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_message ADD CONSTRAINT FK_5AA6C6719395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE `nexo_transaction` ADD CONSTRAINT FK_232B1849F4445056 FOREIGN KEY (devise_id) REFERENCES nexo_devise (id)');
        $this->addSql('ALTER TABLE `nexo_transaction` ADD CONSTRAINT FK_232B18499395C3F3 FOREIGN KEY (customer_id) REFERENCES nexo_customer (id)');
        $this->addSql('ALTER TABLE `nexo_transaction` ADD CONSTRAINT FK_232B18499B6B5FBA FOREIGN KEY (account_id) REFERENCES nexo_account (id)');
        $this->addSql('ALTER TABLE `nexo_transaction` ADD CONSTRAINT FK_232B1849FE347F57 FOREIGN KEY (trans_type_id) REFERENCES nexo_type_transaction (id)');
        $this->addSql('ALTER TABLE `nexo_transaction` ADD CONSTRAINT FK_232B184912469DE2 FOREIGN KEY (category_id) REFERENCES nexo_category_expense (id)');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto ADD CONSTRAINT FK_594CC282A76ED395 FOREIGN KEY (user_id) REFERENCES nexo_user (id)');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto ADD CONSTRAINT FK_594CC28214302A7C FOREIGN KEY (crypto_type_id) REFERENCES nexo_crypto_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity_document DROP FOREIGN KEY FK_9B82D6BF1623CB0A');
        $this->addSql('ALTER TABLE identity_verification DROP FOREIGN KEY FK_664D895EA76ED395');
        $this->addSql('ALTER TABLE nexo_account DROP FOREIGN KEY FK_912DA0AA9395C3F3');
        $this->addSql('ALTER TABLE nexo_account DROP FOREIGN KEY FK_912DA0AAC6798DB');
        $this->addSql('ALTER TABLE nexo_account DROP FOREIGN KEY FK_912DA0AAF4445056');
        $this->addSql('ALTER TABLE nexo_alert DROP FOREIGN KEY FK_141C25899395C3F3');
        $this->addSql('ALTER TABLE nexo_card DROP FOREIGN KEY FK_4195DC519395C3F3');
        $this->addSql('ALTER TABLE nexo_card DROP FOREIGN KEY FK_4195DC51925606E5');
        $this->addSql('ALTER TABLE nexo_card DROP FOREIGN KEY FK_4195DC51F4445056');
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
        $this->addSql('ALTER TABLE nexo_devise DROP FOREIGN KEY FK_3BE98C1EA76ED395');
        $this->addSql('ALTER TABLE nexo_external_account DROP FOREIGN KEY FK_510D5A759395C3F3');
        $this->addSql('ALTER TABLE nexo_external_account DROP FOREIGN KEY FK_510D5A7537E080D9');
        $this->addSql('ALTER TABLE nexo_external_account DROP FOREIGN KEY FK_510D5A75F92F3E70');
        $this->addSql('ALTER TABLE nexo_langue DROP FOREIGN KEY FK_EB535D4FA76ED395');
        $this->addSql('ALTER TABLE nexo_message DROP FOREIGN KEY FK_5AA6C6719395C3F3');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B1849F4445056');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B18499395C3F3');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B18499B6B5FBA');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B1849FE347F57');
        $this->addSql('ALTER TABLE `nexo_transaction` DROP FOREIGN KEY FK_232B184912469DE2');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto DROP FOREIGN KEY FK_594CC282A76ED395');
        $this->addSql('ALTER TABLE nexo_withdraw_crypto DROP FOREIGN KEY FK_594CC28214302A7C');
        $this->addSql('DROP TABLE identity_document');
        $this->addSql('DROP TABLE identity_verification');
        $this->addSql('DROP TABLE nexo_account');
        $this->addSql('DROP TABLE nexo_account_type');
        $this->addSql('DROP TABLE nexo_alert');
        $this->addSql('DROP TABLE nexo_banque');
        $this->addSql('DROP TABLE nexo_card');
        $this->addSql('DROP TABLE nexo_card_type');
        $this->addSql('DROP TABLE nexo_category_expense');
        $this->addSql('DROP TABLE nexo_category_expense_customer');
        $this->addSql('DROP TABLE nexo_country');
        $this->addSql('DROP TABLE nexo_crypto_address');
        $this->addSql('DROP TABLE nexo_crypto_type');
        $this->addSql('DROP TABLE nexo_customer');
        $this->addSql('DROP TABLE nexo_customer_crypto_address');
        $this->addSql('DROP TABLE nexo_deposit_crypto');
        $this->addSql('DROP TABLE nexo_devise');
        $this->addSql('DROP TABLE nexo_external_account');
        $this->addSql('DROP TABLE nexo_flashy');
        $this->addSql('DROP TABLE nexo_langue');
        $this->addSql('DROP TABLE nexo_message');
        $this->addSql('DROP TABLE nexo_settings');
        $this->addSql('DROP TABLE `nexo_transaction`');
        $this->addSql('DROP TABLE nexo_type_transaction');
        $this->addSql('DROP TABLE nexo_user');
        $this->addSql('DROP TABLE nexo_withdraw_crypto');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
