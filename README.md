# Widgetizer

**Widgetizer** is a WordPress plugin that enhances the admin dashboard by providing fully customizable dashboard widget created with the block editor. It allows administrators to tailor the dashboard to present visual information based on user roles.

## Features

- **Dynamic Content Widgets**: Create and manage widgets with custom content.
- **Role-Based Widget Visibility**: Show widgets conditionally based on user roles.
- **Full-Width Dashboard Layout**: Enable full-width widget layouts for a streamlined appearance.

## Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher

## Installation

1. Download the plugin ZIP file or clone the repository.
2. Upload the plugin to your WordPress installation:
   - Via WordPress Admin:
     1. Go to **Plugins > Add New**.
     2. Click **Upload Plugin** and upload the ZIP file.
   - Or manually:
     1. Extract the plugin files and upload them to the `/wp-content/plugins/` directory.
3. Activate the plugin through the **Plugins** menu in WordPress.

## Usage

1. Navigate to **Dashboard > Widgets** to add and manage custom dashboard widgets.
2. Use the settings page (**Settings > Dashboard Widgetizer**) to:
   - Enable full-width dashboard widgets.
   - Hide default WordPress dashboard widgets.
   - Set custom visibility rules for widgets based on user roles.

## Role Management

By default, only administrators can manage widgets. To customize permissions, use a role management plugin such as [Advanced Access Manager (AAM)](https://wordpress.org/plugins/advanced-access-manager/).

## Custom CSS and Styling

Customize widget styles via the plugin settings. Advanced users can enqueue additional styles for greater control.

## Development

### Clone the Repository
```bash
git clone https://github.com/revnoah/wordpress-widgetizer.git
