<?php
    namespace App\Repositories\Frontend;
    use App\Models\Access\User;
    use App\Models\EmailManager;
    use App\Models\Setting;
    use App\Models\Token;
    use App\Repositories\BaseRepository;
    use App\Services\Backend\CpanelTokenService;
    use Illuminate\Support\Facades\DB;

    class SettingRepository extends BaseRepository
    {
        const MODEL = Token::class;

        public function updateCpanelToken(array $input) {
            return DB::transaction(function() use($input) {
                $tokenService = app(CpanelTokenService::class);
                $adminId = User::getUserIdByUid($input['admin_id'])->id;

                if (empty($adminId)) {
                    return false;
                }
                $cpanelDetails = EmailManager::getAdminDetails($adminId);
                if (!$cpanelDetails){
                    return false;
                }
                $cpanelResponse = $tokenService->updateAdminToken(
                    $input['old_name'],
                    $input['new_name'],
                    $cpanelDetails->email_password,
                    $cpanelDetails->domain,
                    $adminId
                );
                return $cpanelResponse === true;
            });
        }

        public function removeAdminToken(array $input) {
            return DB::transaction(function() use($input) {
                $tokenService = app(CpanelTokenService::class);
                $adminId = User::getUserIdByUid($input['admin_id'])->id;

                if (empty($adminId)) {
                    return false;
                }
                $cpanelDetails = EmailManager::getAdminDetails($adminId);
                if (!$cpanelDetails){
                    return false;
                }
                $tokenName = Token::getUserTokenByAdminId($adminId);
                if (!$tokenName){
                    return false;
                }
                $cpanelResponse = $tokenService->removeAdminToken(
                    $tokenName->cpanel_user,
                    $cpanelDetails->cpanel_password,
                    $cpanelDetails->domain,
                    $adminId
                );
                return $cpanelResponse === true;
            });
        }

        public function updatePassword(array $input) {
            return DB::transaction(function() use($input) {
                $user = user();
                $user->update([
                    'password' => $input['password'], // new password
                    'on_login_change_password' => false,
                ]);
                return $user;
            });
        }

        public function updateSystemSetting(array $input)
        {
            return DB::transaction(function() use($input) {
                $setting = Setting::getSettingByUid($input['uid']);
                if (!$setting){
                    return false;
                }
                $cpanelResponse = $setting->update([
                    'whm_user' => $input['whm_user'],
                    'whm_host' => $input['whm_host'],
                    'whm_api_token' => $input['whm_api_token'],
                ]);
                return $cpanelResponse === true;
            });
        }
    }
