@echo off
echo ============================================
echo  FUTH Lafia EMR - Fix Permission Timeout
echo ============================================
echo.

echo STEP 1: Publish Shield config (overwrite)
copy /Y filament-shield.php config\filament-shield.php
echo Done.
echo.

echo STEP 2: Update AdminPanelProvider
copy /Y AdminPanelProvider.php app\Providers\Filament\AdminPanelProvider.php
echo Done.
echo.
echo STEP 3: Update FuthPermissionsSeeder
copy /Y FuthPermissionsSeeder.php database\seeders\FuthPermissionsSeeder.php
echo Done.
echo.
echo STEP 4: Clear all caches
php artisan optimize:clear
echo.
echo STEP 5: Wipe and re-seed permissions (this removes duplicate permissions)
php artisan db:seed --class=FuthPermissionsSeeder
echo.
echo STEP 6: Re-assign roles to existing users
php artisan db:seed --class=FuthEmrSeeder
echo.
echo STEP 7: Clear caches again
php artisan optimize:clear
echo.
echo ============================================
echo  ALL DONE! Try accessing /admin/users now
echo ============================================
pause