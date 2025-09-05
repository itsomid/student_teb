// Constants defining different statuses for classes.
export const CLASS_STATUS = {
    SUSPENDED: [101],         // Class suspended, possibly due to policy violations or other reasons.
    ONGOING: [106],           // Class currently ongoing, actively being conducted.
    FORCE_MESSAGE: [102, 103, 104], // Special status indicating the need for a forced message, possibly for administrative purposes.
    CONDUCTED: [105],         // Class already conducted, has been completed.
    PENDING: [107],           // Class scheduled but not yet started, awaiting commencement.
    DELAYED: [108],           // Class delayed, postponed from its original schedule.
}
export const USER_CLASS_STATUS = {
    1 : {
        title: 'جلسه هنوز شروع نشده',
        icon: '$mdiClockOutline',
        color: 'primary',
    }, // not started yet
    2 : {
        title:  'درحال برگزاری', // is active
        icon: '$mdiDotsCircle',
        color: 'success',
    },
    3 : {
      title: 'تمام شده',  // has been held,
      icon: '$mdiRadioboxMarked',
      color: 'warning',
    },
    4 : {
      title :  'تمام شده (با فیلم ضبط شده adobe)', // with adobe recorded,
      icon: '$mdiDotsCircle',
      color: 'success',
    },
    5 : {
        title : 'درحال برگزاری', // is active (adobe disabled),
        icon: '$mdiDotsCircle',
        color: 'success',
    },
    6 : {
        title: 'درحال برگزاری', // Classino Connect active
        icon: '$mdiDotsCircle',
        color: 'success'
    },
    7 : {
        title: 'درحال برگزاری', // Classino Connect active (adobe disabled)
        icon: '$mdiDotsCircle',
        color: 'success',
    },
    8 : {
        title:  'تعویق جلسه ',
        icon: '$mdiClockAlertOutline',
        color: 'warning'
    }
}

export const CLASS_ONGOING_STATUS = [ 2, 5 ,6 ,7];

export const QUIZ_STATES = {
    DISABLED        : 201,
    ACTIVE          : 202,
    FORCED          : 203,
    RESULT_PENDING  : 204,
    RESULT_RECEIVED : 205,
}

export const HOMEWORK_STATES = {
    ACTIVE          : 301,
    FORCED          : 302,
    DISABLED        : 303,
    SENT            : 304,
}