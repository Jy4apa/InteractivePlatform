
export const routes = [
    // DEFAULT
    {
        path: '/',
        name: 'home',
        component: () => import('@/pages/Home.vue'),
        meta: {
            requiresAuth: false
        }
    },

    // MAIN
    {
        path: '/cabinet',
        name: 'Cabinet',
        component: () => import('@/pages/cabinet/Cabinet.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/profile',
        name: 'Profile',
        component: () => import('@/pages/cabinet/Profile.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/questionnaire',
        name: 'Questionnaire',
        component: () => import('@/pages/cabinet/Questionnaire.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/essay',
        name: 'Essay',
        component: () => import('@/pages/cabinet/Essay.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/internships',
        name: 'Internships',
        component: () => import('@/pages/cabinet/Internships.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/internships/:id',
        name: 'InternshipItem',
        component: () => import('@/pages/cabinet/InternshipItem.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/applications',
        name: 'Applications',
        component: () => import('@/pages/cabinet/Applications.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/school-of-mentors',
        name: 'SchoolOfMentors',
        component: () => import('@/pages/cabinet/SchoolOfMentors.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/statements',
        name: 'Statements',
        component: () => import('@/pages/cabinet/Statements.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/table',
        name: 'Table',
        component: () => import('@/pages/cabinet/Table.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/statistics',
        name: 'Statistics',
        component: () => import('@/pages/cabinet/Statistics.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/notifications',
        name: 'Notifications',
        component: () => import('@/pages/cabinet/Notifications.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },

    //mentors
    {
        path: '/cabinet/applications-mentors',
        name: 'ApplicationsMentors',
        component: () => import('@/pages/cabinet/ApplicationsMentors.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/school',
        name: 'School',
        component: () => import('@/pages/cabinet/School.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/schedule',
        name: 'Schedule',
        component: () => import('@/pages/cabinet/Schedule.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/internships-supervisor',
        name: 'InternshipsSupervisor',
        component: () => import('@/pages/cabinet/InternshipsSupervisor.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },


    //ORGANIZATION
    {
        path: '/cabinet/applications-organization',
        name: 'ApplicationsOrganization',
        component: () => import('@/pages/cabinet/ApplicationsOrganization.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/school-organization',
        name: 'SchoolOrganization',
        component: () => import('@/pages/cabinet/SchoolOrganization.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/rating',
        name: 'Rating',
        component: () => import('@/pages/cabinet/Rating.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },
    {
        path: '/cabinet/applications-organization/:id',
        name: 'ApplicationsOrganizationForm',
        component: () => import('@/pages/cabinet/ApplicationsOrganizationForm.vue'),
        meta: {
            requiresAuth: true,
            layout: 'main',
        }
    },


    // SYSTEM
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFoundPage',
        component: () => import('@/pages/system/Page404.vue'),
        meta: {
            requiresAuth: false,
            layout: 'system',
        },
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/pages/system/Login.vue'),
        meta: {
            requiresAuth: false,
            layout: 'system',
        }
    },
    {
        path: '/registration',
        name: 'Registration',
        component: () => import('@/pages/system/Registration.vue'),
        meta: {
            requiresAuth: false,
            layout: 'system',
        }
    },
];
