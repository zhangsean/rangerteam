<?php
if(!isset($lang->overtime)) $lang->overtime = new stdclass();
$lang->overtime->common = 'Overtime';
$lang->overtime->browse = 'Browse';
$lang->overtime->create = 'Apply';
$lang->overtime->edit   = 'Edit';
$lang->overtime->delete = 'Delete';
$lang->overtime->review = 'Review';
$lang->overtime->cancel = 'Cancel';
$lang->overtime->commit = 'Commit';

$lang->overtime->personal     = 'My Overtime';
$lang->overtime->browseReview = 'Review List';
$lang->overtime->company      = 'All';

$lang->overtime->id           = 'ID';
$lang->overtime->begin        = 'Begin';
$lang->overtime->end          = 'End';
$lang->overtime->start        = 'Start';
$lang->overtime->finish       = 'Finish';
$lang->overtime->hours        = 'Hours';
$lang->overtime->type         = 'Type';
$lang->overtime->desc         = 'Desc';
$lang->overtime->status       = 'Status';
$lang->overtime->createdBy    = 'Created By';
$lang->overtime->createdDate  = 'Created Date';
$lang->overtime->reviewedBy   = 'Reviewed By';
$lang->overtime->reviewedDate = 'Reviewed Date';
$lang->overtime->date         = 'Date';
$lang->overtime->time         = 'Time';

$lang->overtime->typeList['time']    = 'After work';
$lang->overtime->typeList['rest']    = 'On weekends';
$lang->overtime->typeList['holiday'] = 'On holiday';
$lang->overtime->typeList['lieu']    = 'Lieu';

$lang->overtime->statusList['draft']  = 'Draft';
$lang->overtime->statusList['wait']   = 'Wait';
$lang->overtime->statusList['pass']   = 'Pass';
$lang->overtime->statusList['reject'] = 'Reject';

$lang->overtime->denied = 'Denied';
$lang->overtime->unique = '%s has a record.';

$lang->overtime->confirmReview['pass']   = 'Are you sure pass?';
$lang->overtime->confirmReview['reject'] = 'Are you sure reject?';

$lang->overtime->hoursTip = 'Hours';
