<?PHP

namespace Denngarr\Seat\SeatSrp\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuzzleHttp\Client;
use Seat\Web\Http\Controllers\Controller;
use Denngarr\Seat\SeatSrp\Models\KillMail;
use Denngarr\Seat\SeatSrp\Validation\AddKillMail;


class SrpAdminController extends Controller {

    public function srpGetKillMails()
    {
        $killmails = KillMail::where('approved','>','-2')->orderby('created_at', 'desc')->get();

        return view('srp::list', compact('killmails'));
    }

    public function srpApprove($kill_id, $action) {
        $killmail = KillMail::find($kill_id);

        switch ($action)
        {
            case 'Approve':
                $killmail->approved = '1';
                break;
            case 'Reject':
                $killmail->approved = '-1';
                break;
            case 'Paid Out':
                $killmail->approved = '2';
                break;
            case 'Pending':
                $killmail->approved = '0';
                break;
        }

        $killmail->save();

        return json_encode(['name' => $action, 'value' => $kill_id]);
    }
}

