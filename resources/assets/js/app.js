
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// We Planted Trees
require('./components/TreeMain');
require('./components/Tree');

// Campus Management
require('./components/CampusMain');
require('./components/Campus');

// User Management
require('./components/UserMain');
require('./components/User');

// Department Management
require('./components/DepartmentMain');
require('./components/Department');

// Vehicle Management
require('./components/VehicleMain');
require('./components/Vehicle');
require('./components/VehicleActiveMain');
require('./components/VehicleActive');

// Uploaded Trips
require('./components/ExcelUploadMain');
require('./components/ExcelUploadInput');
require('./components/UploadedTripMain');
require('./components/UploadedTrip');

// Sidebar
require('./components/SidebarMain');

// Thresholds
require('./components/ThresholdsMain');

// Notifications
require('./components/NotificationsPopover');
