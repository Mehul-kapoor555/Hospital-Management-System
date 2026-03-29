CREATE DATABASE hospital;
USE hospital;

CREATE TABLE admin(
	username varchar(20),
    password varchar(20),
    role varchar(15),
    UNIQUE(username, password)
);

CREATE TABLE patients(   
	TaxCode VARCHAR(20) PRIMARY KEY,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL, 
    Age INT NOT NULL,
    CONSTRAINT chk_age CHECK (Age > 5),
    Gender VARCHAR(10),
    ContactNumber INT NOT NULL, 
    Address VARCHAR(100) NOT NULL
);


CREATE TABLE departments(  
    DeptName VARCHAR(20) PRIMARY KEY, 
    DeptHead VARCHAR(20)      
);


CREATE TABLE doctors(  # child table for departments
	LicenseNum VARCHAR(20) PRIMARY KEY,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    ContactNumber INT NOT NULL,
    Email VARCHAR(50),
	Charges INT,
    DeptName VARCHAR(20),
    FOREIGN KEY (DeptName) REFERENCES  departments(DeptName) ON DELETE SET NULL ON UPDATE CASCADE,
    DateAdded DATETIME DEFAULT NOW()
);


CREATE TABLE appointments(  # child table for patients, doctors 
	AppointmentID INT PRIMARY KEY, 
    PatientID VARCHAR (20),
    FOREIGN KEY (PatientID) REFERENCES patients(TaxCode),
    DoctorID VARCHAR(20),
    FOREIGN KEY (DoctorID) REFERENCES  doctors(LicenseNum) ,
    Date_Time DATETIME,
    CONSTRAINT unique_appointment UNIQUE (DoctorID, Date_Time)
);


CREATE TABLE medications(
	MedicationID INT PRIMARY KEY,
    MedicationName VARCHAR(20) UNIQUE,
    Dosage VARCHAR(10),
    SideEffects VARCHAR(20),
    InStock BOOLEAN
);

CREATE TABLE treatments(  # child table for patients and medications
	TreatmentID INT AUTO_INCREMENT PRIMARY KEY,
    PatientID VARCHAR(20),
    FOREIGN KEY (PatientID) REFERENCES patients(TaxCode),
    Diagnosis VARCHAR(100),
    MedicationID INT,
    FOREIGN KEY (MedicationID) REFERENCES medications(MedicationID)
);
ALTER TABLE treatments AUTO_INCREMENT = 2000;

CREATE TABLE billing(    # child table for patients, appointments
	BillID INT AUTO_INCREMENT PRIMARY KEY,
    PatientID VARCHAR(20),
    FOREIGN KEY (PatientID) REFERENCES patients(TaxCode),
    AppointmentID INT,  
    FOREIGN KEY (AppointmentID) REFERENCES appointments(AppointmentID),
    Amount FLOAT,
    DateOfBilling DATETIME DEFAULT NOW(),
    PaymentMode VARCHAR(15)  # e.g. Cash, Credit, Insurance
);

ALTER TABLE billing AUTO_INCREMENT = 9000;

CREATE TABLE insurance(
	PolicyNumber INT PRIMARY KEY,
    InsuranceProvider VARCHAR(20),
    CoverageAmount INT,
    PatientID VARCHAR(20),
    FOREIGN KEY (PatientID) REFERENCES patients(TaxCode)
);
