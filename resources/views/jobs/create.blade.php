
<x-layout>
<x-slot name="title">Create a New Job X-Slot</x-slot>
  <div
      class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl"
  >
      <h2 class="text-4xl text-center font-bold mb-4">
          Create Job Listing
      </h2>
      <form
          method="POST"
          action="/jobs"
          enctype="multipart/form-data"
      >
      @csrf <!-- adds a hidden field with a csrf token to make sure the form is being submitted from the webssite is supposed to be submitted from-->

          <h2
              class="text-2xl font-bold mb-6 text-center text-gray-500"
          >
              Job Info
          </h2>

          <x-inputs.text id="title" name="title" label="Job Title" placeholder="eg. Software Engineer"/>

          <x-inputs.text-area id="description" name="description" label="Job Description" placeholder="We are seeking a skilled and motivated Software Developer to join our growing development team..."/>

          <x-inputs.text id="salary" name="salary" label="Salary" type="number" placeholder="eg. 60000"/>

          <x-inputs.text-area id="requirements" name="requirements" label="Job Requirements" placeholder="eg. Bachelor's degree in Computer Science"/>

          <x-inputs.text-area id="benefits" name="benefits" label="Benefits" placeholder="eg. Health insurance, 401k, paid time off"/>

          <x-inputs.text id="tags" name="tags" label="Tags (comma-separated)" placeholder="development,coding,TDD,python"/>

          <x-inputs.select id="job_type" name="job_type" label="Job Type" value="{{old('job_type')}}" :options="['Full-Time' => 'Full-Time', 'Part-Time' => 'Part-Time', 'Contract' => 'Contract', 'Temporary' => 'Temporary', 'Internship' => 'Internship', 'Volunteer' => 'Volunteer', 'On-Call' => 'On-Call']"/>

          <x-inputs.select id="remote" name="remote" label="Remote" :options="[0 => 'No', 1 => 'Yes']"/>

          <x-inputs.text id="address" name="address" label="Address" placeholder="123 Main Street"/>

          <x-inputs.text id="city" name="city" label="City" placeholder="Albany"/>

          <x-inputs.text id="county" name="county" label="County" placeholder="KA"/>

          <x-inputs.text id="postal_code" name="postal_code" label="Postal Code" placeholder="KA1 2NY"/>

          <h2
              class="text-2xl font-bold mb-6 text-center text-gray-500"
          >
              Company Info
          </h2>

          <x-inputs.text id="company_name" name="company_name" label="Company Name" placeholder="Company Name"/>

          <x-inputs.text-area id="company_description" name="company_description" label="Company Description" placeholder="Company Description"/>

          <x-inputs.text id="company_website" name="company_website" label="Company Website" type="url" placeholder="eg. www.example.com"/>

          <x-inputs.text id="phone_number" name="phone_number" label="Contact Phone Number" placeholder="Enter contact phone number"/>

          <x-inputs.text id="email" name="email" label="Contact Email" type="email" placeholder="Email where you want to receive applications"/>

          <x-inputs.file id="company_logo" name="company_logo" label="Company Logo"/>

          <button
              type="submit"
              class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
          >
              Save
          </button>
      </form>
  </div>

</x-layout>