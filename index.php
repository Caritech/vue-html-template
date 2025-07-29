<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vue 3 Single Page</title>
    <script src="assets/vue3.dev.js"></script>
    <link href="assets/bootstrap5.css" rel="stylesheet">


    <style>
        body {
            font-family: Verdana;
            font-size: 12px;
            color: #000000;
        }

        .form-control,
        .form-select {
            padding: 1px 8px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin: 0px 5px;
        }

        .form-check {
            display: flex;
            align-items: center;

        }

        .card-header {
            background: #C6C6B7;
            font-weight: bold;
            font-size: 20px
        }

        .card {
            background: #FDFDF3;
        }

        .form-label {
            margin-bottom: 1px;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="w-100">
                    <div class="text-end">
                        iResume id: xxxx | Login id: xxxx | name: xxxx
                    </div>

                </div>
            </div>
        </nav>
        <form @submit.prevent="saveForm">
            <div class="container-fluid m-2">

                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-2 sidebar p-0">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#tab-personal" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Personal</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#tab-qualification" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Qualification</button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#tab-experience" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Experience</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#tab-additional" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Additional</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#tab-others" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Others</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#tab-applications" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Applicantions</button>
                            <button class="nav-link text-danger" type="button">preference</button>
                            <button class="nav-link text-danger" type="button">viewResume</button>
                            <button class="nav-link text-danger" type="button">printResume</button>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-10 p-2">
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="tab-personal" role="tabpanel" aria-labelledby="tab-personal">

                                <div class="card mb-2">
                                    <div class="card-header">Personal</div>
                                    <div class="card-body">
                                        <p class="text-muted mb-4">
                                            Please take your time to complete the form. Don't forget to fill in your phone and email address.
                                            And if you cannot find the position that you want to apply for, specify in the text box provided next to Position.
                                            (Please note that you have to save on this page to activate your account with us. (* fields marked are required fields..)
                                        </p>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label required">Position</label>
                                                <select class="form-select" v-model="formData.position">
                                                    <option value="">Others, please specify --></option>
                                                    <option value="developer">Software Developer</option>
                                                    <option value="designer">UI/UX Designer</option>
                                                    <option value="manager">Project Manager</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Gender</label>
                                                <select class="form-select" v-model="formData.gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label required">Name</label>
                                                <input type="text" class="form-control" v-model="formPersonal.name">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Old IC</label>
                                                <input type="text" class="form-control" v-model="formData.oldIC">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">New IC</label>
                                                <input type="text" class="form-control" v-model="formData.newIC">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Passport no</label>
                                                <input type="text" class="form-control" v-model="formData.passportNo">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Country</label>
                                                <select class="form-select" v-model="formData.country">
                                                    <option value="">---- Select Country ----</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="TH">Thailand</option>
                                                    <option value="US">United States</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Race</label>
                                                <select class="form-select" v-model="formData.race">
                                                    <option value="chinese">Chinese</option>
                                                    <option value="malay">Malay</option>
                                                    <option value="indian">Indian</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label required">Date of birth</label>
                                                <input type="date" class="form-control" v-model="formData.dateOfBirth">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Marital status</label>
                                                <select class="form-select" v-model="formData.maritalStatus">
                                                    <option value="single">Single</option>
                                                    <option value="married">Married</option>
                                                    <option value="divorced">Divorced</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Your position in family</label>
                                                <select class="form-select" v-model="formData.familyPosition">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Driving license</label>
                                                <select class="form-select" v-model="formData.drivingLicense">
                                                    <option value="none">None</option>
                                                    <option value="car">Car</option>
                                                    <option value="motorcycle">Motorcycle</option>
                                                    <option value="both">Both</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">No of brothers & sisters & you</label>
                                                <select class="form-select" v-model="formData.siblings">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5+">5+</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Section -->
                                <div class="card mb-2">
                                    <div class="card-header fw-bold h4">Contact</div>
                                    <div class="card-body">
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label required">Email</label>
                                                <input type="email" class="form-control" v-model="formData.email">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Mobile</label>
                                                <input type="tel" class="form-control" v-model="formData.mobile">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">House tel</label>
                                                <input type="tel" class="form-control" v-model="formData.houseTel">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Office tel</label>
                                                <input type="tel" class="form-control" v-model="formData.officeTel">
                                            </div>
                                        </div>

                                        <!-- Permanent Address -->
                                        <h6 class="mt-4 mb-3">Permanent Address</h6>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control mb-2" v-model="formData.permanentAddress.line1">
                                                <input type="text" class="form-control" v-model="formData.permanentAddress.line2">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Post code</label>
                                                        <input type="text" class="form-control" v-model="formData.permanentAddress.postCode">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">City/Town</label>
                                                        <input type="text" class="form-control" v-model="formData.permanentAddress.city">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">State</label>
                                                <select class="form-select" v-model="formData.permanentAddress.state">
                                                    <option value="">-</option>
                                                    <option value="kuala-lumpur">Kuala Lumpur</option>
                                                    <option value="selangor">Selangor</option>
                                                    <option value="penang">Penang</option>
                                                    <option value="johor">Johor</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Correspondence Address -->
                                        <h6 class="mt-4 mb-3">Correspondence Address</h6>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" v-model="sameAsPermanent" id="sameAsPermanent">
                                            <label class="form-check-label" for="sameAsPermanent">
                                                same as permanent
                                            </label>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control mb-2" v-model="formData.correspondenceAddress.line1" :disabled="sameAsPermanent">
                                                <input type="text" class="form-control" v-model="formData.correspondenceAddress.line2" :disabled="sameAsPermanent">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Post code</label>
                                                        <input type="text" class="form-control" v-model="formData.correspondenceAddress.postCode" :disabled="sameAsPermanent">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">City/Town</label>
                                                        <input type="text" class="form-control" v-model="formData.correspondenceAddress.city" :disabled="sameAsPermanent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">State</label>
                                                <select class="form-select" v-model="formData.correspondenceAddress.state" :disabled="sameAsPermanent">
                                                    <option value="">-</option>
                                                    <option value="kuala-lumpur">Kuala Lumpur</option>
                                                    <option value="selangor">Selangor</option>
                                                    <option value="penang">Penang</option>
                                                    <option value="johor">Johor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-qualification" role="tabpanel" aria-labelledby="tab-qualification">
                                <div class="card">
                                    <div class="card-header">
                                        Qualification
                                    </div>
                                    <div class="card-body">
                                        QUALIFICAIOTN
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-experience" role="tabpanel" aria-labelledby="tab-experience">
                                <div class="card">
                                    <div class="card-header">
                                        Experience
                                    </div>
                                    <div class="card-body">
                                        EXPERIENCE
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-additional" role="tabpanel" aria-labelledby="tab-additional">
                                <div class="card">
                                    <div class="card-header">
                                        additional
                                    </div>
                                    <div class="card-body">
                                        additional
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-others" role="tabpanel" aria-labelledby="tab-others">
                                <div class="card">
                                    <div class="card-header">
                                        others
                                    </div>
                                    <div class="card-body">
                                        others
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-applications" role="tabpanel" aria-labelledby="tab-applications">
                                <div class="card">
                                    <div class="card-header">
                                        applications
                                    </div>
                                    <div class="card-body">
                                        applications
                                    </div>
                                </div>
                            </div>



                        </div>


                        <!-- Save Buttons -->
                        <div class="d-flex justify-content-end my-4">
                            <p class="me-3 text-muted align-self-center">
                                <strong>Note:</strong> Use menu on top left for navigation.
                            </p>
                            <button type="submit" class="btn btn-success mx-2">Save</button>
                            <button type="button" class="btn btn-primary mx-2" @click="saveAndNext">Save & Next</button>
                        </div>



                    </div>
                </div>
            </div>
        </form>
        <div class="text-center text-muted">
            <small>iResume 2.04.01 30 Mar 2016</small>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="assets/bootstrap5.js"></script>

    <script>
        const RESULT = {
            "name": "Hello world",
            "phone": "+60 115443122",
            "email": "hello@caritech.com",
            "address": "",
            "skills": [
                "PHP",
                "MySQL",
                "Bootstrap CSS Framework",
                "Laravel",
                "Flutter",
                "Javascript",
                "jQuery",
            ],
            "years_of_experience": 3,
            "education": [{
                    "college_university": "The University of Malaysia",
                    "qualification": "Bachelor of Information Technology",
                    "grade": "3.41",
                    "completion_year": "2022",
                    "field_of_study": []
                },
                {
                    "college_university": "SSTech College Penang",
                    "qualification": "Diploma In Computer System and Technology",
                    "grade": "3.85",
                    "completion_year": "2020",
                    "field_of_study": []
                }
            ],
            "work_experience": [{
                    "company": "DEF Sdn Bhd",
                    "role": "Programmer",
                    "start_date": "Jan 2021",
                    "end_date": "Present",
                    "description": "Maintain server"
                },
                {
                    "company": "ABC Sdn Bhd",
                    "role": "Diploma Internship Trainee",
                    "start_date": "Sep 2016",
                    "end_date": "Nov 2016",
                    "description": "debug and enhance existing software"
                }
            ],
            "languages": [{
                    "language": "Mandarin",
                    "spoken": 5,
                    "written": 5
                },
                {
                    "language": "English",
                    "spoken": 5,
                    "written": 5
                }
            ],
            "current_company": "DEF Sdn Bhd",
            "current_position": "Programmer",
            "profile_summary": "Software developer with experience in full-stack development, specializing in PHP (Laravel), MySQL, Vue.js, and Flutter. Adept at designing, developing, and maintaining enterprise applications and feature enhancement. Passionate about creating efficient, scalable, and user-friendly solutions to enhance business operations.",
            "dob": "2000-01-01",
            "linkedin": "",
            "facebook": "",
            "skill_summary": "",
            "certifications": []
        }
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    activeNav: 'personal',
                    sameAsPermanent: false,
                    formData: {
                        permanentAddress: {},
                        correspondenceAddress: {}
                    },
                    formPersonal: {
                        name: '',
                    },
                };
            },
            watch: {
                sameAsPermanent(newVal) {
                    if (newVal) {
                        this.formData.correspondenceAddress = {
                            ...this.formData.permanentAddress
                        };
                    }
                }
            },
            methods: {
                saveForm() {
                    alert('Form saved successfully!');
                    console.log('Form data:', this.formData);
                },
                saveAndNext() {
                    this.saveForm();
                    // Navigate to next section
                    const currentIndex = this.navigation.findIndex(nav => nav.id === this.activeNav);
                    if (currentIndex < this.navigation.length - 1) {
                        this.activeNav = this.navigation[currentIndex + 1].id;
                    }
                }
            },
            created() {

            },
            mounted() {
                this.formPersonal.name = RESULT.name
            }
        }).mount('#app');
    </script>
</body>

</html>