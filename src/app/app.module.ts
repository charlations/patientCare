import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AngularFontAwesomeModule } from 'angular-font-awesome'

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { PatientsComponent } from './patients/patients.component';
import { UiModule } from './ui/ui.module';
import { PatientDetailComponent } from './patient-detail/patient-detail.component';

@NgModule({
  declarations: [
    AppComponent,
    PatientsComponent,
    PatientDetailComponent
  ],
  imports: [
    BrowserModule,
		AppRoutingModule,
		FormsModule,
		AngularFontAwesomeModule,
		UiModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
