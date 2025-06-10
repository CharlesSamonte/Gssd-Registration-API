<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            // Create a 13-digit Student ID
            do {
                $studentIDExists = false;
                $studentID = str_pad(rand(0, 999999999999), 13, '0', STR_PAD_LEFT);
                $studentIDExists = DB::table('Mst_Student')->where('Student_ID', $studentID)->first();
            } while ($studentIDExists);
            $data['Student_ID'] = $studentID;
            $data['Date_of_Registration'] = date('Y-m-d H:i:s');

            DB::table('Mst_Student')->insert([
                "Student_ID" => $data['Student_ID'] ?? null,
                "Legal_Last_Name" => $data['studentLastName'] ?? null,
                "Legal_First_Name" => $data['studentFirstName'] ?? null,
                "Legal_Middle_Name" => $data['studentMiddleName'] ?? null,
                "Legal_Suffix_Code" => $data['studentLegalSuffix'] ?? null,
                "Preferred_Last_Name" => $data['studentPrefLastName'] ?? null,
                "Preferred_First_Name" => $data['studentPrefFirstName'] ?? null,
                "Preferred_Middle_Name" => $data['studentPrefMiddleName'] ?? null,
                "Preferred_Suffix_Code" => $data['studentPrefSuffix'] ?? null,
                "Date_Of_Birth" => $data['dateOfBirth'] ?? null,
                "Gender_Code" => $data['studentGender'] ?? null,
                "Phone_Home" => $data['studentHomePhone'] ?? null,
                "Phone_Cell" => $data['studentCellPhone'] ?? null,
                "Email_Address" => $data['studentEmail'] ?? null,
                "Has_Custody_Order" => $data['hasCustodyOrder'] ?? null,
                "Is_Indigenous" => $data['isIndigenousAncestry'] ?? null,
                "Medical_Notes" => $data['medicalNote'] ?? null,
            ]);

            DB::table('Mst_Registration')->insert([
                "Student_ID" => $data['Student_ID'],
                "Date_of_Registration" => $data['Date_of_Registration'] ?? null,
                "Entry_Date" => $data['entryDate'] ?? null,
                "School_Code" => $data['schoolReceiving'] ?? null,
                "Grade_Level_Code" => $data['grade'] ?? null,
                "English_Only_At_Home" => $data['isHomeEnglishOnly'] ?? null,
                "Medical_Restrictions" => $data['hasMedRestrict'] ?? null,
                "Require_Transportation" => $data['isBusRequired'] ?? null,
                "Origin_School_Name" => $data['originSchool'] ?? null,
                "Origin_School_City" => $data['originSchoolCity'] ?? null,
                "Origin_School_Province" => $data['originSchoolProvince'] ?? null,
                "Origin_School_Country_Code" => $data['originSchoolCountry'] ?? null,
                "French_Immersion" => $data['frenchImmersion'] ?? null,
                "Exchange_Student" => $data['exchangeStudent'] ?? null,
                "Hockey_Team" => $data['hockeyTeam'] ?? null,
                "E_mail_To_Acknowledge_Registration" => $data['lafoipSignatureEmail'] ?? null,
                "SWIS_ID" => $data['swisId'] ?? null,
                "CumFile_Request_Date" => $data['cumFileRequestDate'] ?? null,
                "MSS_Entry_Date" => $data['mssEntryDate'] ?? null,
                "Registration_Person_Role_Code" => $data['registrationPersonRoleCode'] ?? null,
                "Registration_Completed_By_Name" => $data['registrantName'] ?? null,
                "Registration_Log_Filename" => $data['registrationLogFilename'] ?? null,
            ]);

            DB::table('Dtl_Mailing_Address')->insert([
                "Student_ID" => $data['Student_ID'],
                "Box_No" => $data['mailingBoxNo'] ?? null,
                "Rural_Route_No" => $data['mailingRrNo'] ?? null,
                "Apt_No" => $data['mailingAptNo'] ?? null,
                "House_No" => $data['mailingHouseNo'] ?? null,
                "Street" => $data['mailingStreet'] ?? null,
                "City" => $data['mailingCity'] ?? null,
                "Province_Code" => $data['mailingProvince'] ?? null,
                "Postal_Code" => $data['mailingPostalCode'] ?? null,
            ]);

            DB::table('Dtl_Physical_Address')->insert([
                "Student_ID" => $data['Student_ID'],
                "Apt_No" => $data['physAptNo'] ?? null,
                "House_No" => $data['physHouseNo'] ?? null,
                "Street" => $data['physStreet'] ?? null,
                "City" => $data['physCity'] ?? null,
                "Province_Code" => $data['physProvince'] ?? null,
                "Quarter_Code" => $data['physQuarter'] ?? null,
                "Section_Code" => $data['physSection'] ?? null,
                "Township_Code" => $data['physTownship'] ?? null,
                "Range_Code" => $data['physRange'] ?? null,
                "Meridian_Code" => $data['physMeridian'] ?? null,
            ]);

            DB::table('Dtl_Permanent_Address')->insert([
                "Student_ID" => $data['Student_ID'],
                "Apt_No" => $data['permIntAptNo'] ?? null,
                "House_No" => $data['permIntHouseNo'] ?? null,
                "Street" => $data['permIntStreet'] ?? null,
                "City" => $data['permIntCity'] ?? null,
                "Province" => $data['permIntProvince'] ?? null,
                "Country_Code" => $data['permIntCountry'] ?? null,
            ]);


            // LOOPS NEEDED FOR MULTIPLE ENTRIES
            $studentContacts = $data['studentContacts'] ?? [];
            foreach ($studentContacts as $contact) {
                $index = $contact['index'];
                $key = $contact['key'];

                DB::table('Dtl_Student_Contact')->insert([
                    "Student_ID" => $data['Student_ID'],
                    "Student_Contact_ID" => $index ?? null,
                    "Person_Relationship_Code" => $data['contactRelationship-' . $key] ?? null,
                    "Last_Name" => $data['contactLastName-' . $key] ?? null,
                    "First_Name" => $data['contactFirstName-' . $key] ?? null,
                    "Suffix_Code" => $data['contactLegalSuffix-' . $key] ?? null,
                    "Phone_Home" => $data['contactHomePhone-' . $key] ?? null,
                    "Phone_Work" => $data['contactWorkPhone-' . $key] ?? null,
                    "Phone_Cell" => $data['contactCellPhone-' . $key] ?? null,
                    "Emergency_Contact_Priority" => $data['contactPriority-' . $key] ?? null,
                    "Email_address" => $data['contactEmailAdd-' . $key] ?? null,
                    "Home_Address" => $data['contactHomeAddress-' . $key] ?? null,
                    "School_Closure_Contact" => $data['isContactSchoolClosure-' . $key] ?? null,
                    "Edsby_Access" => $data['isContactEdsbyAccess-' . $key] ?? null,
                    "Lives_With_Student" => $data['isContactLivesWith-' . $key] ?? null,
                ]);
            }

            $relatedStudents = $data['relatedStudents'] ?? [];
            foreach ($relatedStudents as $contact) {
                $index = $contact['index'];
                $key = $contact['key'];

                DB::table('Dtl_Related_Student')->insert([
                    "Student_ID" => $data['Student_ID'],
                    "First_Name" => $data['relatedStudentFirstName-' . $key] ?? null,
                    "Last_Name" => $data['relatedStudentLastName-' . $key] ?? null,
                    "School" => $data['relatedStudentSchool-' . $key] ?? null,
                    "Grade" => $data['relatedStudentGrade-' . $key] ?? null,
                    "Student_Relationship_Code" => $data['relatedStudentRelationship-' . $key] ?? null,
                ]);
            }

            // Emergency Contacts
            // Emergency Contact, Childcare Provider, Billet Information
            if (isset($data['hasEmergencyContact']) && $data['hasEmergencyContact'] == '1') {
                DB::table('Dtl_Emergency_Contact')->insert([
                    "Student_ID" => $data['Student_ID'],
                    "Name" => $data['emergencyContName'] ?? null,
                    "Person_Relationship_Code" => $data['emergencyContRelationship'] ?? null,
                    "Phone_Home" => $data['emergencyContHomePhone'] ?? null,
                    "Phone_Cell" => $data['emergencyContCellPhone'] ?? null,
                ]);
            }
            if (isset($data['hasChildcareProvider']) && $data['hasChildcareProvider'] == '1') {
                DB::table('Dtl_Emergency_Contact')->insert([
                    "Student_ID" => $data['Student_ID'],
                    "Name" => $data['childcareName'] ?? null,
                    "Person_Relationship_Code" => "Caregiver/Babysitter",
                    "Phone_Home" => $data['childcareHomePhone'] ?? null,
                    "Phone_Cell" => $data['childcareCellPhone'] ?? null,
                ]);
            }
            if (isset($data['billetName']) && !empty($data['billetName'])) {
                DB::table('Dtl_Emergency_Contact')->insert([
                    "Student_ID" => $data['Student_ID'],
                    "Name" => $data['billetName'] ?? null,
                    "Person_Relationship_Code" => "Billet",
                    "Phone_Home" => $data['billetHomePhone'] ?? null,
                    "Phone_Cell" => $data['billetCellPhone'] ?? null,
                ]);
            }
            ////////////////////////////////

            if (isset($data['isIndigenousAncestry']) && $data['isIndigenousAncestry'] == '1') {
                DB::table('Dtl_Indigenous_Declaration')->insert([
                    "Student_ID" => $data['Student_ID'],
                    "Indigenous_Group_Code" => $data['indigenousGroup'] ?? null,
                    "Indian_Registry_No" => $data['indigenousRegistryNo'] ?? null,
                    "Band_Affiliation_Code" => $data['indigenousBandName'] ?? null,
                    "Lives_On_Reserve" => $data['studentResidesOnReserve'] ?? null,
                    "Reserve_Of_Residence_Code" => $data['reserveResidence'] ?? null,
                ]);
            }

            // DB::table('Dtl_Immigration_Status')->insert([
            //     "Student_ID" => $data[''],
            //     "SK_Resident" => $data[''],
            //     "Birth_Country_Code" => $data[''],
            //     "Citizenship_Country_Code" => $data[''],
            //     "Languages_At_Home_1" => $data[''],
            //     "Languages_At_Home_2" => $data[''],
            //     "Immigration_Status_Code" => $data[''],
            //     "Immigration_Document_Type_Code" => $data[''],
            //     "Document_Expiry_Date" => $data[''],
            //     "Entry_Date_Canada" => $data[''],
            //     "CUAET_Program" => $data[''],
            // ]);

            // CONSENT FORMS HERE
            /////////////////////

            DB::commit(); // Finalize transaction
            return ['status' => 'success'];

        } catch (\Exception $e) {
            DB::rollBack(); // Undo changes on failure
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function validateData(array $data)
    {
        // Perform validation logic here
    }
}