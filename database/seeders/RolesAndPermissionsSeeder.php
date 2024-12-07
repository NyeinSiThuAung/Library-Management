<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use App\Enum\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seeds the database with roles and permissions.
     *
     * This seeder performs the following tasks:
     * 1. **Resets cached roles and permissions:** Clears any cached data to ensure fresh operations.
     * 2. **Creates roles:** Iterates through the `RoleEnum` and creates corresponding roles in the database.
     * 3. **Creates permissions:** Iterates through the `PermissionEnum` and creates corresponding permissions in the database.
     * 4. **Assigns permissions to roles:**
     *    - **Admin role:** Grants all permissions to the admin role.
     *    - **Librarian role:** Grants specific permissions related to book management.
     *    - **Member role:** Grants permissions related to reading and borrowing books.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        foreach (RoleEnum::cases() as $role) {
            Role::create(['name' => $role->value]);
        }

        // Create Permissions
        foreach (PermissionEnum::cases() as $permission) {
            Permission::create(['name' => $permission->value]);
        }

        // Assign Permissions to Roles
        Role::findByName(RoleEnum::Admin->value)->givePermissionTo(PermissionEnum::cases());
        Role::findByName(RoleEnum::Librarian->value)->givePermissionTo([
            PermissionEnum::CreateBooks->value,
            PermissionEnum::ReadBooks->value,
            PermissionEnum::UpdateBooks->value,
            PermissionEnum::DeleteBooks->value,
        ]);
        Role::findByName(RoleEnum::Member->value)->givePermissionTo([
            PermissionEnum::ReadBooks->value,
            PermissionEnum::BorrowBooks->value,
            PermissionEnum::ReturnBooks->value,
        ]);
    }
}
