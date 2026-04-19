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
|   |   ├── features/       # Smart components
|   |   ├── pages/          # Route level pages
|   |   ├── shared/         # 
|   |   ├── styles/         # 
|   ├── index.php
|
├── server/                 # Backend
|   ├── config/             # Database configurations, Environment setups
|   ├── controllers/        # 
|   ├── models/             # Database schemas
|   ├── routes/             # 
|   ├── tests/              # Unit and integration tests.
|
├── shared/                 # Shared by frontend and backend
|   ├── constant.php
```