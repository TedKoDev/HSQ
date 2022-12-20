import classhistorylist from "../pages/classlist.js";
import feedbacklist from "../pages/feedbacklist.js";
import reviewlist from "../pages/reviewlist.js";

export const BASE_URL = "http://localhost";

export const routes = [
  { path: /^\/teacherpage\/classhistory\/classlist\/$/, element: classhistorylist },
  { path: /^\/teacherpage\/classhistory\/feedbacklist\/$/, element: feedbacklist },
  { path: /^\/teacherpage\/classhistory\/reviewlist\/$/, element: reviewlist },
];