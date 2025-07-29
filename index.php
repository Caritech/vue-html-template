<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vue 3 Single Page</title>
    <script src="assets/vue3.prod.js"></script>
    <link href="assets/bootstrap5.css" rel="stylesheet">


    <style>
        body {
            font-family: Verdana;
            font-size: 12px;
            color: #000000;
        }

        .form-control, .form-select {
            padding: 1px 8px;
        }
        .form-check-input{
            width: 20px;
            height:20px;
            margin:0px 5px;
        }
        .form-check{
            display: flex;
            align-items: center;
            
        }

        .card-header {
            background: #C6C6B7;
        }

        .card {
            background: #FDFDF3;
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
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Personal</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Qualification</button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Experience</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Additional</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Others</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Applicantions</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Preference</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">viewResume</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">printResume</button>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-10">
                        <div class="p-4">
                            <div class="card mb-2">
                                <div class="card-header fw-bold h4">Personal</div>
                                <div class="card-body">
                                    <p class="text-muted mb-4">
                                        Please take your time to complete the form. Don't forget to fill in your phone and email address.
                                        And if you cannot find the position that you want to apply for, specify in the text box provided next to Position.
                                        (Please note that you have to save on this page to activate your account with us. (* fields marked are required fields..)
                                    </p>

                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label required">Name</label>
                                            <input type="text" class="form-control" v-model="formData.name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Old IC</label>
                                            <input type="text" class="form-control" v-model="formData.oldIC">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">New IC</label>
                                            <input type="text" class="form-control" v-model="formData.newIC">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Passport no</label>
                                            <input type="text" class="form-control" v-model="formData.passportNo">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
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
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label required">Email</label>
                                            <input type="email" class="form-control" v-model="formData.email">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Mobile</label>
                                            <input type="tel" class="form-control" v-model="formData.mobile">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
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
                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
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



                            <!-- Save Buttons -->
                            <div class="d-flex justify-content-end mb-4">
                                <p class="me-3 text-muted align-self-center">
                                    <strong>Note:</strong> Use menu on top left for navigation.
                                </p>
                                <button type="submit" class="btn btn-custom">Save</button>
                                <button type="button" class="btn btn-custom" @click="saveAndNext">Save & Next</button>
                            </div>

                            <div class="text-center text-muted">
                                <small>iResume 2.04.01 30 Mar 2016</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="assets/bootstrap5.js"></script>

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    activeNav: 'personal',
                    sameAsPermanent: false,
                    navigation: [{
                            id: 'personal',
                            label: 'personal'
                        },
                        {
                            id: 'qualification',
                            label: 'qualification'
                        },
                        {
                            id: 'experience',
                            label: 'experience'
                        },
                        {
                            id: 'additional',
                            label: 'additional'
                        },
                        {
                            id: 'others',
                            label: 'others'
                        },
                        {
                            id: 'applications',
                            label: 'applications'
                        },
                        {
                            id: 'preference',
                            label: 'preference'
                        },
                        {
                            id: 'viewResume',
                            label: 'viewResume'
                        },
                        {
                            id: 'printResume',
                            label: 'printResume'
                        }
                    ],
                    formData: {
                        position: '',
                        name: '',
                        gender: '',
                        oldIC: '',
                        newIC: '',
                        passportNo: '',
                        country: '',
                        race: '',
                        dateOfBirth: '',
                        maritalStatus: '',
                        familyPosition: '',
                        siblings: '',
                        drivingLicense: '',
                        email: '',
                        mobile: '',
                        houseTel: '',
                        officeTel: '',
                        permanentAddress: {
                            line1: '',
                            line2: '',
                            postCode: '',
                            city: '',
                            state: ''
                        },
                        correspondenceAddress: {
                            line1: '',
                            line2: '',
                            postCode: '',
                            city: '',
                            state: ''
                        }
                    }
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
            }
        }).mount('#app');
    </script>
</body>

</html>