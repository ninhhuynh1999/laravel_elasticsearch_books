CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE users (
    user_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    contact JSONB NOT NULL,
    profile_image VARCHAR(255),
    role VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    address TEXT,
    note TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE category (
    category_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT
);

CREATE TABLE supplier (
    supplier_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    contact JSONB,
    address TEXT,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT
);

CREATE TABLE customer (
    customer_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    sex VARCHAR(50),
    email VARCHAR(255),
    phone_number VARCHAR(50),
    sales_order_information JSONB,
    address TEXT,
    type VARCHAR(100),
    note TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    tags TEXT[],
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT
);

CREATE TABLE location (
    location_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    contact JSONB NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    admin_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT
);

CREATE TABLE product (
    product_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    category_id UUID REFERENCES category(category_id) ON DELETE SET NULL,
    supplier_id UUID NOT NULL REFERENCES supplier(supplier_id) ON DELETE RESTRICT,
    barcode VARCHAR(255) UNIQUE,
    sku VARCHAR(255) UNIQUE,
    name VARCHAR(255) NOT NULL,
    current_stock INTEGER NOT NULL DEFAULT 0,
    min_stock INTEGER NOT NULL DEFAULT 0,
    max_stock INTEGER NOT NULL DEFAULT 0,
    description TEXT,
    sale_price INTEGER NOT NULL DEFAULT 0,
    purchase_price INTEGER NOT NULL DEFAULT 0,
    details JSONB,
    optional_details JSONB,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    status VARCHAR(50),
    images TEXT[],
    tags TEXT[],
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT,
    CHECK (current_stock >= 0),
    CHECK (min_stock >= 0),
    CHECK (max_stock >= min_stock),
    CHECK (sale_price >= 0),
    CHECK (purchase_price >= 0)
);

CREATE TABLE promotion (
    promotion_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    type VARCHAR(100),
    type_name VARCHAR(255),
    apply_to_quantity INTEGER,
    used_quantity INTEGER NOT NULL DEFAULT 0,
    remain_quantity INTEGER,
    apply_from_amount INTEGER NOT NULL DEFAULT 0,
    apply_to_amount INTEGER,
    discount_rate INTEGER NOT NULL DEFAULT 0,
    discount_value INTEGER NOT NULL DEFAULT 0,
    start_at TIMESTAMPTZ NOT NULL,
    close_at TIMESTAMPTZ,
    is_active BOOLEAN DEFAULT TRUE,
    status VARCHAR(50),
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT,
    CHECK (used_quantity >= 0),
    CHECK (apply_from_amount >= 0),
    CHECK (apply_to_amount > apply_from_amount),
    CHECK (discount_rate BETWEEN 0 AND 100),
    CHECK (discount_value >= 0),
    CHECK (close_at > start_at)
);

CREATE TABLE purchase_order (
    purchase_order_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    supplier_id UUID NOT NULL REFERENCES supplier(supplier_id) ON DELETE RESTRICT,
    items JSONB NOT NULL,
    sub_total INTEGER NOT NULL DEFAULT 0,
    tax INTEGER NOT NULL DEFAULT 0,
    discount_items JSONB,
    discount_rate INTEGER NOT NULL DEFAULT 0,
    discount_value INTEGER NOT NULL DEFAULT 0,
    discount_amount INTEGER NOT NULL DEFAULT 0,
    total_amount INTEGER NOT NULL DEFAULT 0,
    payment_details JSONB,
    status VARCHAR(50),
    note TEXT,
    tags TEXT[],
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT,
    CHECK (sub_total >= 0),
    CHECK (tax >= 0),
    CHECK (discount_rate BETWEEN 0 AND 100),
    CHECK (discount_value >= 0),
    CHECK (discount_amount >= 0),
    CHECK (total_amount >= 0)
);

CREATE TABLE sales_order (
    sales_order_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    return_date TIMESTAMPTZ,
    customer_type VARCHAR(100),
    customer_id UUID NOT NULL REFERENCES customer(customer_id) ON DELETE RESTRICT,
    items JSONB,
    subtotal INTEGER NOT NULL DEFAULT 0,
    discount_items JSONB,
    discount_rate INTEGER NOT NULL DEFAULT 0,
    discount_value INTEGER NOT NULL DEFAULT 0,
    discount_amount INTEGER NOT NULL DEFAULT 0,
    tax INTEGER NOT NULL DEFAULT 0,
    total_amount INTEGER NOT NULL DEFAULT 0,
    payment_details JSONB NOT NULL,
    status VARCHAR(50),
    note TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT,
    CHECK (subtotal >= 0),
    CHECK (discount_rate BETWEEN 0 AND 100),
    CHECK (discount_value >= 0),
    CHECK (discount_amount >= 0),
    CHECK (tax >= 0),
    CHECK (total_amount >= 0)
);

CREATE TABLE return_order (
    return_order_id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    sales_order_id UUID NOT NULL REFERENCES sales_order(sales_order_id) ON DELETE RESTRICT,
    customer_id UUID NOT NULL REFERENCES customer(customer_id) ON DELETE RESTRICT,
    user_id UUID NOT NULL REFERENCES users(user_id) ON DELETE RESTRICT,
    items JSONB NOT NULL,
    total_item INTEGER NOT NULL DEFAULT 0,
    total_quantity INTEGER NOT NULL DEFAULT 0,
    total_amount INTEGER NOT NULL DEFAULT 0,
    note TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CHECK (total_item >= 0),
    CHECK (total_quantity >= 0),
    CHECK (total_amount >= 0)
);

-- Create indexes for frequently queried columns
CREATE INDEX idx_product_category ON product(category_id);
CREATE INDEX idx_product_supplier ON product(supplier_id);
CREATE INDEX idx_sales_order_customer ON sales_order(customer_id);
CREATE INDEX idx_return_order_sales_order ON return_order(sales_order_id);