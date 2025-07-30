<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración Hospitalario</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuración de Tailwind para usar Inter font y colores personalizados -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#3B82F6', // Azul para elementos principales
                        secondary: '#10B981', // Verde para acciones secundarias/éxito
                        accent: '#F59E0B', // Naranja para advertencias/destacados
                        background: '#F9FAFB', // Fondo claro
                        card: '#FFFFFF', // Fondo de tarjetas
                        text: '#1F2937', // Color de texto principal
                        lightText: '#6B7280', // Color de texto secundario
                    }
                }
            }
        }
    </script>
    <!-- Chart.js CDN para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB; /* Fondo claro */
        }
        /* Estilos para el scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Ocultar scrollbar en IE, Edge, Firefox */
        body {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-card text-text w-64 p-6 flex flex-col space-y-6 shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50 fixed md:relative h-full overflow-y-auto rounded-r-lg">
        <div class="flex items-center space-x-3 mb-6">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            <h1 class="text-2xl font-bold text-primary">Hospital Admin</h1>
        </div>

        <!-- Selector de Rol -->
        <div class="mb-6">
            <label for="role-selector" class="block text-lightText text-sm font-semibold mb-2">Seleccionar Rol:</label>
            <select id="role-selector" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 text-text">
                <option value="administrador">Administrador</option>
                <option value="enfermeria">Enfermería</option>
                <option value="doctor">Doctor</option>
                <option value="laboratorio">Laboratorio</option>
                <option value="urgencias">Urgencias</option>
            </select>
        </div>

        <!-- Navegación Principal -->
        <nav class="flex-grow">
            <ul class="space-y-2">
                <li>
                    <a href="#" data-module="dashboard" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" data-module="pacientes" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M12 20.354a4 4 0 110-5.292M12 14.354a4 4 0 110-5.292"></path></svg>
                        Pacientes
                    </a>
                </li>
                <li>
                    <a href="#" data-module="medicos" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Médicos
                    </a>
                </li>
                <li>
                    <a href="#" data-module="enfermeria" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Enfermería
                    </a>
                </li>
                <li>
                    <a href="#" data-module="laboratorio" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Laboratorio
                    </a>
                </li>
                <li>
                    <a href="#" data-module="urgencias" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Urgencias
                    </a>
                </li>
                <li class="border-t border-gray-200 pt-2 mt-2">
                    <a href="#" data-module="configuracion" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.26 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Configuración
                    </a>
                </li>
                <li>
                    <a href="#" data-module="usuarios" class="nav-link flex items-center p-3 text-lightText hover:bg-primary hover:text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M17 20v-2c0-.134-.01-.265-.029-.395M12 12V5m0 0a2 2 0 100-4 2 2 0 000 4zm0 13a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                        Gestión de Usuarios
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido Principal -->
    <div class="flex-1 flex flex-col bg-background rounded-l-lg overflow-hidden">
        <!-- Header del Contenido Principal -->
        <header class="bg-card shadow-sm p-4 flex items-center justify-between md:justify-end sticky top-0 z-40 rounded-tl-lg">
            <button id="menu-toggle" class="md:hidden p-2 rounded-md text-lightText hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-semibold text-primary md:hidden">Panel Hospitalario</h2>
            <div class="flex items-center space-x-4">
                <span class="text-lightText text-sm">Bienvenido, <span id="current-user-role" class="font-semibold text-primary">Administrador</span></span>
                <!-- Aquí podrías añadir un menú de perfil de usuario -->
            </div>
        </header>

        <!-- Área de Contenido Dinámico -->
        <main id="content-area" class="flex-1 p-6 overflow-y-auto">
            <!-- El contenido se cargará aquí dinámicamente -->
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');
            const navLinks = document.querySelectorAll('.nav-link');
            const contentArea = document.getElementById('content-area');
            const roleSelector = document.getElementById('role-selector');
            const currentUserRoleSpan = document.getElementById('current-user-role');

            let currentRole = roleSelector.value; // Rol inicial

            // Función para alternar la visibilidad de la barra lateral en móviles
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Función para cerrar la barra lateral cuando se hace clic en un enlace en móviles
            const closeSidebar = () => {
                if (window.innerWidth < 768) { // md breakpoint in Tailwind is 768px
                    sidebar.classList.add('-translate-x-full');
                }
            };

            // Función para actualizar el contenido del área principal
            const loadContent = (moduleName) => {
                contentArea.innerHTML = ''; // Limpiar contenido anterior
                let contentHTML = '';

                switch (moduleName) {
                    case 'dashboard':
                        contentHTML = `
                            <h1 class="text-3xl font-bold text-text mb-6">Dashboard Principal</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                <!-- Tarjetas de Métricas Rápidas -->
                                <div class="bg-card p-6 rounded-lg shadow-md flex items-center justify-between">
                                    <div>
                                        <p class="text-lightText text-sm">Pacientes Activos</p>
                                        <p class="text-3xl font-bold text-primary">1,234</p>
                                    </div>
                                    <svg class="w-12 h-12 text-primary opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M12 20.354a4 4 0 110-5.292M12 14.354a4 4 0 110-5.292"></path></svg>
                                </div>
                                <div class="bg-card p-6 rounded-lg shadow-md flex items-center justify-between">
                                    <div>
                                        <p class="text-lightText text-sm">Citas Hoy</p>
                                        <p class="text-3xl font-bold text-secondary">87</p>
                                    </div>
                                    <svg class="w-12 h-12 text-secondary opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="bg-card p-6 rounded-lg shadow-md flex items-center justify-between">
                                    <div>
                                        <p class="text-lightText text-sm">Camas Disponibles</p>
                                        <p class="text-3xl font-bold text-accent">25</p>
                                    </div>
                                    <svg class="w-12 h-12 text-accent opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19v-7a2 2 0 012-2h10a2 2 0 012 2v7M5 19H3a2 2 0 01-2-2v-4a2 2 0 012-2h18a2 2 0 012 2v4a2 2 0 01-2 2h-2M5 19a2 2 0 002 2h10a2 2 0 002-2"></path></svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Gráfico de Pacientes por Especialidad -->
                                <div class="bg-card p-6 rounded-lg shadow-md">
                                    <h3 class="text-lg font-semibold text-text mb-4">Pacientes por Especialidad</h3>
                                    <canvas id="specialtyChart"></canvas>
                                </div>
                                <!-- Gráfico de Citas Mensuales -->
                                <div class="bg-card p-6 rounded-lg shadow-md">
                                    <h3 class="text-lg font-semibold text-text mb-4">Citas Mensuales</h3>
                                    <canvas id="appointmentsChart"></canvas>
                                </div>
                                <!-- Gráfico de Ocupación de Camas -->
                                <div class="bg-card p-6 rounded-lg shadow-md col-span-1 lg:col-span-2">
                                    <h3 class="text-lg font-semibold text-text mb-4">Ocupación de Camas</h3>
                                    <canvas id="bedOccupancyChart"></canvas>
                                </div>
                            </div>
                        `;
                        break;
                    case 'pacientes':
                        contentHTML = `
                            <h1 class="text-3xl font-bold text-text mb-6">Gestión de Pacientes</h1>
                            <div class="bg-card p-6 rounded-lg shadow-md">
                                <p class="text-lightText mb-4">Aquí se gestionarán los pacientes. Se pueden realizar operaciones CRUD.</p>
                                <!-- Ejemplo de formulario para añadir/editar paciente -->
                                <form id="patient-form" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="patient-name" class="block text-sm font-medium text-text">Nombre</label>
                                            <input type="text" id="patient-name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary" placeholder="Nombre del paciente">
                                        </div>
                                        <div>
                                            <label for="patient-id" class="block text-sm font-medium text-text">ID Paciente</label>
                                            <input type="text" id="patient-id" name="patient_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary" placeholder="ID único">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="patient-diagnosis" class="block text-sm font-medium text-text">Diagnóstico</label>
                                        <textarea id="patient-diagnosis" name="diagnosis" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary" placeholder="Diagnóstico principal"></textarea>
                                    </div>
                                    <button type="submit" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">Guardar Paciente</button>
                                </form>

                                <h3 class="text-xl font-semibold text-text mt-8 mb-4">Listado de Pacientes</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">ID</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Nombre</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Diagnóstico</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-lightText uppercase tracking-wider">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text">P001</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-lightText">Juan Pérez</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-lightText">Fiebre</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="#" class="text-primary hover:text-blue-900 mr-2">Editar</a>
                                                    <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text">P002</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-lightText">María García</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-lightText">Fractura</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="#" class="text-primary hover:text-blue-900 mr-2">Editar</a>
                                                    <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                        break;
                    case 'medicos':
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Gestión de Médicos</h1><p class="text-lightText">Contenido para la gestión de médicos (CRUD).</p>`;
                        break;
                    case 'enfermeria':
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Gestión de Enfermería</h1><p class="text-lightText">Contenido para la gestión de personal de enfermería (CRUD).</p>`;
                        break;
                    case 'laboratorio':
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Gestión de Laboratorio</h1><p class="text-lightText">Contenido para la gestión de pruebas de laboratorio y resultados (CRUD).</p>`;
                        break;
                    case 'urgencias':
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Gestión de Urgencias</h1><p class="text-lightText">Contenido para la gestión de casos de urgencia (CRUD).</p>`;
                        break;
                    case 'configuracion':
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Configuración del Sistema</h1><p class="text-lightText">Contenido para la configuración general del hospital.</p>`;
                        break;
                    case 'usuarios':
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Gestión de Usuarios y Roles</h1><p class="text-lightText">Contenido para la gestión de usuarios y sus roles (CRUD).</p>`;
                        break;
                    default:
                        contentHTML = `<h1 class="text-3xl font-bold text-text mb-6">Bienvenido al Panel</h1><p class="text-lightText">Selecciona un módulo del menú lateral.</p>`;
                }
                contentArea.innerHTML = contentHTML;

                // Si es el dashboard, inicializar los gráficos
                if (moduleName === 'dashboard') {
                    initializeCharts();
                }

                // Si es el módulo de pacientes, añadir el listener al formulario
                if (moduleName === 'pacientes') {
                    const patientForm = document.getElementById('patient-form');
                    if (patientForm) {
                        patientForm.addEventListener('submit', handlePatientFormSubmit);
                    }
                }
            };

            // Manejador de clic para los enlaces de navegación
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const moduleName = e.currentTarget.dataset.module;
                    loadContent(moduleName);
                    closeSidebar(); // Cierra la sidebar en móviles después de la selección
                });
            });

            // Función para inicializar los gráficos del dashboard
            const initializeCharts = () => {
                // Gráfico de Pacientes por Especialidad
                const specialtyCtx = document.getElementById('specialtyChart');
                if (specialtyCtx) {
                    new Chart(specialtyCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Cardiología', 'Pediatría', 'Ortopedia', 'Neurología', 'Otros'],
                            datasets: [{
                                data: [300, 200, 150, 100, 484],
                                backgroundColor: [
                                    '#3B82F6', // primary
                                    '#10B981', // secondary
                                    '#F59E0B', // accent
                                    '#EF4444', // red
                                    '#6B7280'  // lightText
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: false,
                                    text: 'Pacientes por Especialidad'
                                }
                            }
                        }
                    });
                }

                // Gráfico de Citas Mensuales
                const appointmentsCtx = document.getElementById('appointmentsChart');
                if (appointmentsCtx) {
                    new Chart(appointmentsCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Citas',
                                data: [65, 59, 80, 81, 56, 55],
                                backgroundColor: '#3B82F6', // primary
                                borderColor: '#3B82F6',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: false,
                                    text: 'Citas Mensuales'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // Gráfico de Ocupación de Camas
                const bedOccupancyCtx = document.getElementById('bedOccupancyChart');
                if (bedOccupancyCtx) {
                    new Chart(bedOccupancyCtx, {
                        type: 'line',
                        data: {
                            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5'],
                            datasets: [{
                                label: 'Camas Ocupadas',
                                data: [75, 80, 70, 85, 90],
                                fill: false,
                                borderColor: '#10B981', // secondary
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: false,
                                    text: 'Ocupación de Camas'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100
                                }
                            }
                        }
                    });
                }
            };

            // Función para manejar el envío del formulario de pacientes (ejemplo CRUD)
            const handlePatientFormSubmit = async (e) => {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                // Simulación de envío a una API RESTful
                console.log('Datos del formulario de paciente:', Object.fromEntries(formData.entries()));

                // Aquí es donde harías tu llamada fetch a la API PHP
                // try {
                //     const response = await fetch('/api/patients', {
                //         method: 'POST',
                //         body: formData
                //     });
                //     const result = await response.json();
                //     if (response.ok) {
                //         console.log('Paciente guardado con éxito:', result);
                //         // Actualizar la tabla de pacientes o mostrar un mensaje de éxito
                //         alert('Paciente guardado con éxito!'); // Usar un modal personalizado en producción
                //         form.reset(); // Limpiar el formulario
                //     } else {
                //         console.error('Error al guardar paciente:', result);
                //         alert('Error al guardar paciente: ' + (result.message || 'Error desconocido')); // Usar un modal personalizado
                //     }
                // } catch (error) {
                //     console.error('Error de red o del servidor:', error);
                //     alert('Error de conexión. Inténtalo de nuevo.'); // Usar un modal personalizado
                // }

                // Simulación de éxito
                alert('¡Paciente guardado con éxito (simulado)!'); // Reemplazar con un modal UI real
                form.reset();
                // Aquí podrías recargar la lista de pacientes
            };


            // Manejador para el cambio de rol
            roleSelector.addEventListener('change', (e) => {
                currentRole = e.target.value;
                currentUserRoleSpan.textContent = currentRole.charAt(0).toUpperCase() + currentRole.slice(1); // Capitalizar
                console.log('Rol seleccionado:', currentRole);
                // Aquí podrías implementar lógica para mostrar/ocultar elementos del menú o contenido
                // basándote en el 'currentRole'. Por ejemplo:
                // navLinks.forEach(link => {
                //     if (currentRole === 'enfermeria' && link.dataset.module === 'medicos') {
                //         link.style.display = 'none';
                //     } else {
                //         link.style.display = 'flex'; // o block, dependiendo del estilo
                //     }
                // });
                loadContent('dashboard'); // Recargar el dashboard o la vista inicial para el nuevo rol
            });

            // Cargar el dashboard por defecto al iniciar
            loadContent('dashboard');
        });
    </script>
</body>
</html>
