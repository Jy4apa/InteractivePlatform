export const config = {
  apiUrl: import.meta.env.VITE_APP_API_URL || ''
}

export const STORAGE_KEYS = {
  ACCESS: "auth:token",
};

export const USER_ROLES = {
  ROLE_CANDIDATE: 0, //кандидат
  ROLE_INTERN: 1, //стажер
  ROLE_SUPERVISOR: 2, //куратор
  ROLE_MENTOR: 3, //наставник
  ROLE_ORGANIZATION_MEMBER: 4 //кадровый специалист
}

export const CANDIDATE_STATUSES = {
  STATUS_PENDING: 0,
  STATUS_SUCCESS: 1,
  STATUS_CANCEL: 2,
  STATUS_CONFIRM: 3,
}

export default config