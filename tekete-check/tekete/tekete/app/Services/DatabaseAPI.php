<?php

    namespace App\Services;

    //use App\Models\UserModel;
    use App\Models\User;
    use App\Models\Incident;
    use App\Models\Technician;
    use App\Models\company;
    //use App\Models\IncidentModel;

    /**
     * Class DatabaseAPI.
     */
    class DatabaseAPI
    {
        //function to fetch a user by ID from the 'users' table
        public function getUserById($user_id){
            //return Users::find($user_id);
            return User::where('user_id', $user_id)->first();
        }
        //function to fetch a user by email from the 'users' table
        public function getUserByEmail($email){
            return User::where('email', $email)->first();
        }
        // function to fetch all Technicians from the 'technician' table
        public function getTechniciansById($technnician_id){
            return Technician::find($technnician_id);
        }
        // function to fetch Technicians by email from the 'technician' table
        public function getTechnicianByEmail($email){
            return Technician::where('email', $email)->first();
        }
        public function countTechnicians()
        {
            return Technician::count();
        }
         // function to fetch all company by ID from the 'company' table
       /* public function getCompanyById($company_id){
            return Company::find($company_id);
        }*/
        public function getCompanyById($company_id){
            return Company::where('company_id', $company_id)->first();
        }
        //function to get a count of all users
        public function countUsers(){
            return User::count();
        }
        // Function to retrieve all users associated with a particular company
        public function getUserByCompanyId($company_id){
            return User::where('company_id', $company_id)->get();
        }
        //function to get incidents based on their status
        public function getIncidentsByStatus($status){
            return Incident::where('status', $status)->get();
        }
        // Function to get the total number of incidents reported by a specific company
        public function getIncidentCountByCompany($companyId)
        {
            return Incident::where('company_id', $companyId)->count();
        }
        public function getActiveTickets($userId){
            return Incident::where('user_id', $userId)->get();
            /*return Incidents::where('user_id', $userId)
            ->where('status', '!=', 'Completed')
             ->get();
             */
        }
        public function getCompletedTickets($userId){
            return Incident::where('user_id', $userId)->where('status', 'Completed')->get();
        }
    }
