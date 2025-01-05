-- Drop existing indexes (optional)
DROP INDEX IF EXISTS idx_email;
DROP INDEX IF EXISTS idx_username;
DROP INDEX IF EXISTS idx_name;
DROP INDEX IF EXISTS idx_production_date;
DROP INDEX IF EXISTS idx_assigned_baker;
DROP INDEX IF EXISTS idx_batch_number;
DROP INDEX IF EXISTS idx_status;
DROP INDEX IF EXISTS idx_batch_id;
DROP INDEX IF EXISTS idx_user_id;
DROP INDEX IF EXISTS idx_check_time;

-- Table for users (bakers and supervisor)
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL CHECK (role IN ('baker', 'supervisor')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for users table
CREATE INDEX IF NOT EXISTS idx_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_username ON users(username);

-- Table for recipes
CREATE TABLE IF NOT EXISTS recipes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    ingredients JSONB NOT NULL,
    steps JSONB NOT NULL,
    equipment JSONB,
    prep_time INT NOT NULL, -- Preparation time in minutes
    yield INT NOT NULL, -- Number of items produced
    created_by INT REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index for recipes table
CREATE INDEX IF NOT EXISTS idx_name ON recipes(name);

-- Table for production schedules
CREATE TABLE IF NOT EXISTS production_schedules (
    id SERIAL PRIMARY KEY,
    recipe_id INT NOT NULL REFERENCES recipes(id) ON DELETE CASCADE,
    order_id VARCHAR(255) NOT NULL,
    production_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    quantity INT NOT NULL,
    assigned_baker INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    equipment_needed JSONB,
    status VARCHAR(50) DEFAULT 'scheduled' CHECK (status IN ('scheduled', 'in_progress', 'completed', 'cancelled')),
    created_by INT REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for production_schedules table
CREATE INDEX IF NOT EXISTS idx_production_date ON production_schedules(production_date);
CREATE INDEX IF NOT EXISTS idx_assigned_baker ON production_schedules(assigned_baker);

-- Table for batches
CREATE TABLE IF NOT EXISTS batches (
    id SERIAL PRIMARY KEY,
    batch_number VARCHAR(255) NOT NULL,
    production_schedule_id INT NOT NULL REFERENCES production_schedules(id) ON DELETE CASCADE,
    start_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    end_time TIMESTAMP,
    status VARCHAR(50) DEFAULT 'in_progress' CHECK (status IN ('in_progress', 'completed', 'failed')),
    notes TEXT,
    quality_checks JSONB DEFAULT NULL, -- Array of quality check objects
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for batches table
CREATE INDEX IF NOT EXISTS idx_batch_number ON batches(batch_number);
CREATE INDEX IF NOT EXISTS idx_status ON batches(status);

-- Table for batch assignments (for task assignments)
CREATE TABLE IF NOT EXISTS batch_assignments (
    id SERIAL PRIMARY KEY,
    batch_id INT NOT NULL REFERENCES batches(id) ON DELETE CASCADE,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL CHECK (status IN ('Pending', 'In Progress', 'Completed')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for batch_assignments table
CREATE INDEX IF NOT EXISTS idx_batch_id ON batch_assignments(batch_id);
CREATE INDEX IF NOT EXISTS idx_user_id ON batch_assignments(user_id);

-- Table for batch quality checks (for detailed quality tracking)
CREATE TABLE IF NOT EXISTS batch_quality_checks (
    id SERIAL PRIMARY KEY,
    batch_id INT NOT NULL REFERENCES batches(id) ON DELETE CASCADE,
    checker_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    parameters JSONB NOT NULL, -- Quality check parameters
    result VARCHAR(50) NOT NULL CHECK (result IN ('passed', 'failed')),
    remarks TEXT,
    check_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for batch_quality_checks table
CREATE INDEX IF NOT EXISTS idx_batch_id ON batch_quality_checks(batch_id);
CREATE INDEX IF NOT EXISTS idx_check_time ON batch_quality_checks(check_time);
