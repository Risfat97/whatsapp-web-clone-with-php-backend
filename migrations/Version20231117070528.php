<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117070528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating table messages';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable("messages")) {
            $table = $schema->createTable("messages");

            $table->addColumn("id", Types::INTEGER, [
                "unsigned" => true,
                "notnull" => true,
                "autoincrement" => true
            ]);

            $table->addColumn("sender_id", Types::INTEGER, [
                "unsigned" => true,
                "notnull" => false
            ]);

            $table->addColumn("receiver_id", Types::INTEGER, [
                "unsigned" => true,
                "notnull" => false
            ]);

            $table->addColumn("content", Types::STRING, [
                "columnDefinition" => "TEXT",
            ]);

            $table->addColumn("content_type", Types::STRING, [
                "default" => "text",
                "length" => 16
            ]);

            $table->addColumn("media", Types::STRING);

            $table->addColumn("mime", Types::STRING, [
                "length" => 24
            ]);

            $table->addColumn("created_at", Types::DATETIME_IMMUTABLE, [
                "notnull" => true,
                "default" => "CURRENT_TIMESTAMP"
            ]);

            $table->setPrimaryKey(["id"]);

            $table->addForeignKeyConstraint("users", ["sender_id"], ["id"], [
                "onUpdate" => "CASCADE",
                "onDelete" => "SET NULL"
            ], 'FK1_users_messages');

            $table->addForeignKeyConstraint("users", ["receiver_id"], ["id"], [
                "onUpdate" => "CASCADE",
                "onDelete" => "SET NULL"
            ], 'FK2_users_messages');
        }

    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable("messages")) {
            $schema->dropTable("messages");
        }
    }
}