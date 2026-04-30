# Orbit Captone Project

## Casing
| Casing | Condition |
|--|--|
| camelCase | Variables, functions |
| PascalCase | Classes |
| snake_case | Database table and columns |
| kebab-case | File names, urls, css classes |

## Folder Structure
```
Orbit
├── client/                 # Frontend
|   ├── src/
|   |   ├── app/            # Global setup
|   |   ├── assets/         # Static assets (images, icons, fonts)
|   |   ├── features/       # Organized by features in the system
|   |   ├── pages/          # Route level pages - login, dashboard
|   |   ├── shared/         # Shared components
|   |   ├── styles/         # CSS
|   |   ├── services/       # Sends data to the backend and redirects to the correct pages. 
|   |   ├── upload/         # Folder storing all the user profile picture.
|   ├── index.php
|
├── server/                 # Backend
|   ├── config/             # Database configurations, Environment setups
|   ├── controllers/        # Contains the classes to run a feature.
|   ├── data/               # Contains the map data and svg
|   ├── logic/              # Reusable functions and algorithm
|   ├── models/             # Database schemas, CRUD operations
|   ├── routes/             # Connects with client side - input and output
|   ├── tests/              # Unit and integration tests.
|
├── shared/                 # Shared by frontend and backend
|   ├── constant.php
```

## Important Note
```
User Admin -> admin@example.com, user@dm1n
Course Admin -> academic@example.com, course@dm1n
Schedule Admin -> schedule@example.com, schedule@dm1n
```