# Laravel ToDo App

Laravel 13.17 application with Vite + Tailwind CSS 4.0. SQLite for development.

## Commands

```bash
# Dev server (runs php artisan dev + vite)
composer dev

# Test suite (clears config then runs PHPUnit)
composer test

# Initial setup
composer setup
```

Run single test:
```bash
php artisan test --filter=TestMethodName
```

## Code Conventions

### Controllers
- Thin controllers mandatory
- Validation >3 lines → extract to FormRequest: `php artisan make:request StoreTaskRequest`
- Resource routes use explicit naming: `Route::resource('tasks', TaskController::class);`
- Manual routes require name: `->name('tasks.index')`

### Models
- PascalCase singular: `Task`, `OrderHeader`
- Always define `$fillable` to prevent mass-assignment
- Relationships preferred over raw joins

### Migrations & DB
- Table names: `snake_case` plural (`tasks`, `user_settings`)
- Foreign keys: `constrained()->cascadeOnDelete()`
- Explicit data types and defaults required

### Blade & Forms
- Every form needs `@csrf`
- DELETE/PUT/PATCH requires `@method('DELETE')` inside POST form
- Escape output: `{{ $var }}` (default)
- Raw output: `{!! $sanitized !!}` (only when pre-sanitized)

### Naming Reference
| Element        | Convention           | Example                    |
|----------------|----------------------|----------------------------|
| Model          | PascalCase singular  | `Task`                     |
| Controller     | PascalCase singular  | `TaskController`           |
| Migration      | snake_case plural    | `create_tasks_table`       |
| Table          | snake_case plural    | `tasks`                    |
| Column         | snake_case           | `is_completed`, `user_id`  |
| Route name     | dot.notation         | `tasks.index`              |
| Blade view     | snake_case           | `tasks/index.blade.php`    |

## Testing

PHPUnit uses sqlite in-memory (`:memory:`). Tests run in `testing` environment with array cache/session drivers.

Feature tests in `tests/Feature`, unit tests in `tests/Unit`.

## Frontend

Vite dev server: `npm run dev` (runs separately from Laravel)
Build assets: `npm run build`

Tailwind CSS 4.0 utility-first. Mobile-first responsive (`sm:`, `md:`, `lg:`).

## Quirks

- Composer script `composer dev` runs `php artisan dev` (Laravel 13 dev command)
- Route model binding uses `findOrFail` implicitly
- Avoid N+1: use eager loading `with()` on relationships
- `.env` never committed, keep `.env.example` updated
