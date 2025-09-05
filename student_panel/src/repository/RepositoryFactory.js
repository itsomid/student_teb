import AuthRepository from "./AuthRepository";
import UserRepository from "@/repository/UserRepository";
import ChatRepository from "@/repository/ChatRepository";
import CartRepository from "@/repository/CartRepository";
import NotificationRepository from "@/repository/NotificationRepository";
import BulletinBoardRepository from "@/repository/BulletinBoardRepository";
import BannerRepository from "@/repository/BannerRepository";
import CourseRepository from "@/repository/CourseRepository";
import ClassRepository from "@/repository/ClassRepository";
import PanelRepository from "@/repository/PanelRepository";
import StoreRepository from "@/repository/StoreRepository";
import PaymentRepository from "@/repository/PaymentRepository";
import FinanceRepository from "./FinanceRepository";
import WeeklyScheduleRepository from "@/repository/WeeklyScheduleRepository";
import ValleRepository from "@/repository/ValleRepository";
import OstadinoRepository from "@/repository/OstadinoRepository";
import CampaignRepository from "@/repository/CampaignRepo";

/**
 * Object containing various repositories for API calls.
 * @namespace repositories
 * @property {Object} Auth          - Repository for authentication-related API calls.
 * @property {Object} User          - Repository for user-related API calls.
 * @property {Object} Chat          - Repository for chat-related API calls.
 * @property {Object} Cart          - Repository for cart-related API calls.
 * @property {Object} BulletinBoard - Repository for bulletin-board-related API calls.
 * @property {Object} Banner        - Repository for banner-related API calls.
 * @property {Object} Course        - Repository for course-related API calls.
 * @property {Object} Class         - Repository for class-related API calls.
 * @property {Object} Panle         - Repository for panel-related API calls.
 * @property {Object} Store         - Repository for Store-related API calls.
 * @property {Object} Payment       - Repository for Payment-related API calls.
 * @property {Object} Finance       - Repository for finance-related API calls.
 * @property {Object} Schedule      - Repository for schedule-related API calls.
 * @property {Object} Valle         - Repository for valle-related API calls.
 * @property {Object} Ostadino      - Repository for ostadino-related API calls.
 * @property {Object} Campaign      - Repository for campaign-related API calls.
 */
const repositories = {
    'Auth'          : AuthRepository,
    'User'          : UserRepository,
    'Chat'          : ChatRepository,
    'Cart'          : CartRepository,
    'Notification'  : NotificationRepository,
    'BulletinBoard' : BulletinBoardRepository,
    'Banner'        : BannerRepository,
    'Course'        : CourseRepository,
    'Class'         : ClassRepository,
    'Panel'         : PanelRepository,
    'Store'         : StoreRepository,
    'Payment'       : PaymentRepository,
    'Finance'       : FinanceRepository,
    'Schedule'      : WeeklyScheduleRepository,
    'Valle'         : ValleRepository,
    'Ostadino'      : OstadinoRepository,
    'Campaign'      : CampaignRepository,
};


/**
 * Provides access to the specified repository.
 *
 * @function
 * @memberof repositories
 * @name get
 * @param {string} name - The name of the repository to retrieve.
 * @returns {Object} - The specified repository object.
 * @throws Will throw an error if the specified repository name is not found.
 *
 * @example
 * // Usage:
 * const authRepo = repositories.get('Auth');
 * authRepo.login({'mobile': '09120000000'})
 *     .then(response => {
 *         // Handle authentication success
 *     })
 *     .catch(error => {
 *         // Handle authentication error
 *     });
 */
export default {
    get: name => repositories[name]
};