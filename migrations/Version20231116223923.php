<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116223923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating table contacts';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable("contacts")) {
            $table = $schema->createTable("contacts");

            $table->addColumn("id", Types::INTEGER, [
                "unsigned" => true,
                "notnull" => true,
                "autoincrement" => true
            ]);

            $table->addColumn("user_id", Types::INTEGER, [
                "unsigned" => true,
                "notnull" => true,
            ]);

            $table->addColumn("user_contact_id", Types::INTEGER, [
                "unsigned" => true,
            ]);

            $table->addColumn("created_at", Types::DATETIME_IMMUTABLE);

            $table->setPrimaryKey(["id"]);

            $table->addUniqueIndex([
                "user_id",
                "user_contact_id"
            ], 'UQ_user_id_user_contact_id');

            $table->addForeignKeyConstraint("users", ["user_id"], ["id"], [
                "onUpdate" => "CASCADE",
                "onDelete" => "CASCADE"
            ], 'FK1_users_contacts');

            $table->addForeignKeyConstraint("users", ["user_contact_id"], ["id"], [
                "onUpdate" => "CASCADE",
                "onDelete" => "CASCADE"
            ], 'FK2_users_contacts');
        }

    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable("contacts")) {
            $schema->dropTable("contacts");
        }
    }
}
