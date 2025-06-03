CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "role" varchar check("role" in('admin', 'customer')) not null default 'customer',
  "company_name" varchar,
  "vat_number" varchar,
  "phone" varchar,
  "address" varchar,
  "city" varchar,
  "postal_code" varchar,
  "country" varchar,
  "is_approved" tinyint(1) not null default '0'
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "companies"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "vat_number" varchar,
  "address" varchar,
  "city" varchar,
  "postal_code" varchar,
  "country" varchar,
  "phone" varchar,
  "email" varchar,
  "website" varchar,
  "notes" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "categories"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "description" text,
  "parent_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  "icon_svg" text,
  "icon_image" varchar,
  "attributes" text,
  foreign key("parent_id") references "categories"("id") on delete set null
);
CREATE UNIQUE INDEX "categories_slug_unique" on "categories"("slug");
CREATE TABLE IF NOT EXISTS "products"(
  "id" integer primary key autoincrement not null,
  "quantity" integer not null,
  "price" numeric,
  "category_id" integer,
  "created_at" datetime,
  "updated_at" datetime,
  "type" varchar not null,
  "producer" varchar not null,
  "model" varchar not null,
  "cpu" varchar,
  "ram" varchar,
  "drive" varchar,
  "operating_system" varchar,
  "gpu" varchar,
  "has_box" tinyint(1) not null default '0',
  "color" varchar,
  "screen_size" varchar,
  "lcd_quality" varchar,
  "battery" varchar,
  "visual_grade" varchar,
  "info" text,
  "name" varchar,
  "slug" varchar,
  "batch_number" varchar,
  "description" text,
  "status" varchar check("status" in('available', 'reserved', 'sold')) not null default 'available',
  "condition" varchar check("condition" in('new', 'refurbished', 'used')) not null default 'used',
  foreign key("category_id") references "categories"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "product_specifications"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "key" varchar not null,
  "value" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "orders"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "status" varchar check("status" in('pending', 'confirmed', 'cancelled', 'completed')) not null default 'pending',
  "total_amount" numeric not null,
  "notes" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "product_images"(
  "id" integer primary key autoincrement not null,
  "product_id" integer not null,
  "image_path" varchar not null,
  "is_primary" tinyint(1) not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "inquiries"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "company" varchar,
  "phone" varchar,
  "message" text not null,
  "product_id" integer,
  "status" varchar check("status" in('new', 'in_progress', 'resolved')) not null default 'new',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references "products"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "order_items"(
  "id" integer primary key autoincrement not null,
  "order_id" integer not null,
  "product_id" integer not null,
  "quantity" integer not null,
  "price" numeric not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("product_id") references products("id") on delete cascade on update no action,
  foreign key("order_id") references "orders"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "personal_access_tokens"(
  "id" integer primary key autoincrement not null,
  "tokenable_type" varchar not null,
  "tokenable_id" integer not null,
  "name" varchar not null,
  "token" varchar not null,
  "abilities" text,
  "last_used_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens"(
  "tokenable_type",
  "tokenable_id"
);
CREATE UNIQUE INDEX "personal_access_tokens_token_unique" on "personal_access_tokens"(
  "token"
);
CREATE TABLE IF NOT EXISTS "batch_product"(
  "id" integer primary key autoincrement not null,
  "batch_id" integer not null,
  "product_id" integer not null,
  "quantity" integer not null default '1',
  "unit_price" numeric,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("batch_id") references "batches"("id") on delete cascade,
  foreign key("product_id") references "products"("id") on delete cascade
);
CREATE UNIQUE INDEX "batch_product_batch_id_product_id_unique" on "batch_product"(
  "batch_id",
  "product_id"
);
CREATE TABLE IF NOT EXISTS "third_party_suppliers"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "website" varchar,
  "logo" varchar,
  "description" text,
  "integration_type" varchar check("integration_type" in('api', 'scraping', 'manual', 'other')) not null default 'api',
  "credentials" text,
  "is_active" tinyint(1) not null default '0',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "third_party_suppliers_slug_unique" on "third_party_suppliers"(
  "slug"
);
CREATE UNIQUE INDEX "products_slug_unique" on "products"("slug");
CREATE UNIQUE INDEX "products_batch_number_unique" on "products"(
  "batch_number"
);
CREATE TABLE IF NOT EXISTS "batches"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "reference_code" varchar,
  "description" text,
  "total_price" numeric not null default('0'),
  "total_quantity" integer not null default('0'),
  "status" varchar not null default('draft'),
  "available_from" date,
  "available_until" date,
  "created_at" datetime,
  "updated_at" datetime,
  "product_type" varchar,
  "product_manufacturer" varchar,
  "product_model" varchar,
  "unit_quantity" integer not null default('1'),
  "unit_price" numeric,
  "specifications" text,
  "cpu" varchar,
  "ram" varchar,
  "storage" varchar,
  "gpu" varchar,
  "os" varchar,
  "screen_size" varchar,
  "screen_resolution" varchar,
  "internal_memory" varchar,
  "camera" varchar,
  "battery_capacity" varchar,
  "hdd_capacity" varchar,
  "hdd_type" varchar,
  "hdd_interface" varchar,
  "condition_grade" varchar,
  "visual_grade" varchar,
  "notes" text,
  "images" text,
  "category_id" integer,
  "source_type" varchar,
  "supplier" varchar,
  "source_reference" varchar,
  "batch_cost" numeric,
  "shipping_cost" numeric,
  "tax_amount" numeric,
  "total_cost" numeric,
  "external_reference" varchar,
  "slug" varchar,
  "total_units" integer default '0',
  "products" text,
  foreign key("category_id") references "categories"("id") on delete set null
);
CREATE INDEX "batches_slug_index" on "batches"("slug");

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_05_31_002703_create_companies_table',1);
INSERT INTO migrations VALUES(5,'2025_05_31_002707_create_categories_table',1);
INSERT INTO migrations VALUES(6,'2025_05_31_002711_create_products_table',1);
INSERT INTO migrations VALUES(7,'2025_05_31_002716_create_product_specifications_table',1);
INSERT INTO migrations VALUES(8,'2025_05_31_002717_create_order_items_table',1);
INSERT INTO migrations VALUES(9,'2025_05_31_002717_create_orders_table',1);
INSERT INTO migrations VALUES(10,'2025_05_31_002717_create_product_images_table',1);
INSERT INTO migrations VALUES(11,'2025_05_31_002718_create_inquiries_table',1);
INSERT INTO migrations VALUES(12,'2025_05_31_002723_add_fields_to_users_table',1);
INSERT INTO migrations VALUES(13,'2025_05_31_003327_fix_order_items_foreign_key',1);
INSERT INTO migrations VALUES(14,'2025_05_31_005304_create_personal_access_tokens_table',1);
INSERT INTO migrations VALUES(15,'2025_05_31_015207_update_products_table',1);
INSERT INTO migrations VALUES(16,'2025_05_31_015227_create_batches_table',1);
INSERT INTO migrations VALUES(17,'2025_05_31_015230_create_batch_product_table',1);
INSERT INTO migrations VALUES(18,'2025_05_31_020939_add_icon_to_categories_table',2);
INSERT INTO migrations VALUES(19,'2025_05_31_023257_create_third_party_suppliers_table',3);
INSERT INTO migrations VALUES(20,'2025_06_01_075254_add_missing_columns_to_products_table',4);
INSERT INTO migrations VALUES(21,'2025_06_01_224519_add_product_attributes_to_batches_table',5);
INSERT INTO migrations VALUES(22,'2024_06_15_101010_add_products_to_batches_table',6);
INSERT INTO migrations VALUES(23,'2025_06_02_004747_add_category_id_to_batches_table',7);
INSERT INTO migrations VALUES(24,'2025_06_02_022343_add_source_fields_to_batches_table',8);
INSERT INTO migrations VALUES(25,'2025_06_02_023010_add_cost_fields_to_batches_table',9);
INSERT INTO migrations VALUES(26,'2025_06_02_033156_add_source_fields_to_batches_table',10);
INSERT INTO migrations VALUES(27,'2025_06_02_033352_add_slug_to_batches_table',11);
INSERT INTO migrations VALUES(28,'2025_06_02_055053_remove_products_column_from_batches_table',12);
INSERT INTO migrations VALUES(29,'2025_06_02_060255_add_products_column_to_batches_table',13);
