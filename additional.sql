create table cart_header (
    id int primary key auto_increment,
    user_uuid varchar(40) not null,
    is_completed smallint,
    foreign key(user_uuid) references new_users(uuid)
) default collate latin1_swedish_ci;

create table cart_detail (
    id int primary key identity,
    header_id int,
    product_uuid varchar(40),
    amount int,
    note varchar(255),
    foreign key(header_id) references cart_header(id),
    foreign key(product_uuid) references products(uuid)
)

create table payment_methods (
    id int primary key,
    method_name varchar(32)
);

create table cities (
    id int primary key,
    city_name varchar(32)
);

create table transactions (
    id int primary key,
    cart_id int,
    delivery_address text,
    phone_number varchar(16),
    city_id int,
    postal_code varchar(12),
    payment_method int,
    payment_date date,
    payment_approved_date date,
    completed_date date,
    foreign key(payment_method) references payment_methods(id),
    foreign key(city_id) references cities(id)
);

create table deliveries (
    id int primary key,
    seller_id varchar(40),
    transaction_id int,
    airwaybill varchar(128),
    foreign key(seller_uuid) references new_users(uuid)
);

create table favorite_headers (
    id int primary key,
    user_uuid varchar(40),
    foreign key(user_uuid) references new_users(uuid)
);

create table favorite_details (
    id int primary key,
    product_uuid varchar(40),
    added_date date,
    foreign key(product_uuid) references products(uuid)
);

create table banks (
    id int primary key,
    bank_name varchar(32)
);

create table promotions_header (
    id int primary key,
    seller_uuid varchar(40),
    valid_until date,
    foreign key(seller_uuid) references users(uuid)
);

create table promotions_detail (
    id int primary key,
    product_uuid varchar(40),
    foreign key(product_uuid) references products(uuid)
);

create table discussions (
    id int primary key,
    parent_id int primary key,
    product_uuid varchar(40),
    content text
);--consider using node trait?
