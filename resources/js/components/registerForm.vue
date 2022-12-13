<template>
    <v-app id="inspire">
      <v-main>
        <v-container fluid fill-height>
          <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
              <v-card class="elevation-12">
                <v-toolbar dark color="primary">
                  <v-toolbar-title>Register</v-toolbar-title>                                  
                </v-toolbar>
                <v-card-text>
                  <v-form>
                    <v-text-field  name="fullname" v-model="user.fullname" label="Full Name" type="text"></v-text-field>
                    <v-text-field  name="email" v-model="user.email" label="Email Address" type="text"></v-text-field>
                    <v-select
                    v-model="user.selectedCountry"
                    :items="user.countries"
                    label="Country"
                    item-text="name"  
                    item-value="idd"                
                    @input="atInput"
                    return-object    
                    name="country"
                    >
                    <template  v-slot:selection="slotProps">
                       {{ slotProps.item.flag }} {{ slotProps.item.name }}
                    </template>
                    <template v-slot:item="slotProps"  v-bind:value="{ idd: slotProps.item.idd }" >
                        <i :class="['mr-2', 'em']">{{slotProps.item.flag}}</i>
                         {{slotProps.item.name}}
                        </template>
                    </v-select>

                   
         
                    
                    <v-text-field id="phonenumber" v-model="user.countryCode"  name="phonenumber" label="Phone Number" type="text"></v-text-field>
                    <v-text-field id="password"  v-model="user.password"  name="password" label="Password" type="password"></v-text-field>
                    <v-text-field id="password" v-model="user.password_confirmation"  name="password_confirmation" label="Confirm Password" type="password" required></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn type="submit" color="primary" @click="register">Register</v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-main>
    </v-app>
  </template>
  
  <script>
    import countries from '../../data/countries.json'
    export default {
    data: ()=> ({
        user: {
            fullname: "",
            email: "",
            selectedCountry: "",                       
            countries: countries, 
            countryCode: "",
            countryName: "",
            password: "",
            password_confirmation: ""                   
        }
      }),
    methods: {
      atInput(e,v) {
       //console.log(e.name)
      this.user.countryCode = "("+e.idd+") ";
      this.user.countryName = e.name;
      // console.log(this.countryCode)
    },
    register(){
      console.log(this.user)
      axios
        .post("/register",{
            fullname: this.user.fullname,
            email: this.user.email,
            selectedCountry: this.user.selectedCountry,
            countryCode: this.user.countryCode.match(/\(([^)]+)\)/)[1],
            phoneNumber: this.user.countryCode,
            countryName: this.user.countryName,
            password: this.user.password,
            password_confirmation: this.user.password_confirmation
        })
        .then(response => {
            console.log(response.data)
        })
        .catch(error => {
            console.log("ERRRR:: ",error.response.data);

        });
        // this.$control.dispatch("controlUser/registerUser/", this.user)
    }
    }
        
    }
    

  </script>